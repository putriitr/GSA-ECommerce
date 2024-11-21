<?php

namespace App\Http\Controllers\Customer\Order;

use App\Http\Controllers\Controller;
use App\Models\BigSale;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Parameter;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; 

class OrderController extends Controller
{

    // Show the customer's order
    public function showOrder($orderId)
    {
        $order = Order::find($orderId);
        return view('customer.order.show', compact('order'));
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        // Get the status filter from the request or default to 'semua'
        $status = $request->input('status', 'semua');

        // Fetch orders based on the status filter with pagination
        $orders = Order::where('user_id', $user->id)
                        ->when($status !== 'semua', function ($query) use ($status) {
                            $query->where('status', $status);
                        })
                        ->orderBy('created_at', 'desc')
                        ->paginate(5); // Paginate 10 orders per page

        // Count orders with the 'pending_payment' status
        $waitingForPaymentCount = Order::where('user_id', $user->id)
                                    ->where('status', 'pending_payment')
                                    ->count();

        return view('customer.settings.order.index', compact('orders', 'status', 'user', 'waitingForPaymentCount'));
    }

    


    // Checkout - Create an order
    public function checkout(Request $request)
{
    $user = auth()->user();
    $cartItems = Cart::where('user_id', $user->id)->get();

    if ($cartItems->isEmpty()) {
        return redirect()->back()->with('error', 'Your cart is empty.');
    }

    // Validasi stok produk
    foreach ($cartItems as $item) {
        $product = $item->product;

        if ($item->quantity > $product->stock) {
            return redirect()->back()->with('error', "Product '{$product->name}' is out of stock or insufficient for your quantity. Current stock is {$product->stock} and your quantity is {$item->quantity}. Please reduce your quantity or contact admin.");
        }
    }

    // Mulai transaksi database
    DB::beginTransaction();
    try {
        // Hitung total
        $total = 0;
        foreach ($cartItems as $item) {
            $product = $item->product;

            // Get active Big Sale for the product
            $activeBigSale = BigSale::where('status', true)
                ->where('start_time', '<=', now())
                ->where('end_time', '>=', now())
                ->whereHas('products', function ($query) use ($product) {
                    $query->where('t_product.id', $product->id);
                })
                ->first();

            // If the product is in an active Big Sale, apply Big Sale price
            if ($activeBigSale) {
                if ($activeBigSale->discount_amount) {
                    $productPrice = $product->price - $activeBigSale->discount_amount; // Apply flat discount
                } elseif ($activeBigSale->discount_percentage) {
                    $productPrice = $product->price - ($activeBigSale->discount_percentage / 100) * $product->price; // Apply percentage discount
                }
            } else {
                // If not in Big Sale, use the discount_price or regular price
                $productPrice = $product->discount_price ?? $product->price;
            }

            // Add to total
            $total += $item->quantity * $productPrice;
        }

        // Buat pesanan
        $order = Order::create([
            'user_id' => $user->id,
            'total' => $total,
            'status' => Order::STATUS_WAITING_APPROVAL, // gunakan konstanta untuk status
            'waiting_approval_at' => now(),
        ]);

        // Tambahkan item ke pesanan
        foreach ($cartItems as $item) {
            $product = $item->product;
            $productPrice = $product->discount_price ?? $product->price;

            // Check if the product is in an active Big Sale
            $activeBigSale = BigSale::where('status', true)
                ->where('start_time', '<=', now())
                ->where('end_time', '>=', now())
                ->whereHas('products', function ($query) use ($product) {
                    $query->where('t_product.id', $product->id);
                })
                ->first();

            if ($activeBigSale) {
                // Apply Big Sale price
                if ($activeBigSale->discount_amount) {
                    $productPrice = $product->price - $activeBigSale->discount_amount;
                } elseif ($activeBigSale->discount_percentage) {
                    $productPrice = $product->price - ($activeBigSale->discount_percentage / 100) * $product->price;
                }
            }

            // Add product item to the order
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $productPrice,
                'total' => $item->quantity * $productPrice,
            ]);

            // Kurangi stok produk
            $product->decrement('stock', $item->quantity);
        }

        // Kosongkan keranjang setelah checkout
        Cart::where('user_id', $user->id)->delete();

        // Commit transaksi database
        DB::commit();

        return redirect()->route('customer.order.show', $order->id)->with('success', 'Checkout completed.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'An error occurred during checkout: ' . $e->getMessage());
    }
}





    // Submit payment proof
    public function submitPaymentProof(Request $request, $orderId)
{
    // Cari pesanan berdasarkan ID
    $order = Order::find($orderId);

    // Cek apakah pesanan sudah dibatalkan
    if ($order->status === Order::STATUS_CANCELLED_BY_SYSTEM) {
        return back()->with('info', 'Pesanan Anda telah dibatalkan karena tidak ada pembayaran.');
    }

    // Validasi bukti pembayaran
    $request->validate([
        'payment_proof' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
    ], [
        'payment_proof.required' => 'Harap unggah bukti pembayaran.',
        'payment_proof.mimes' => 'Format file harus berupa JPG, JPEG, PNG, atau PDF.',
        'payment_proof.max' => 'Ukuran file maksimum adalah 2 MB.',
    ]);

    // Simpan bukti pembayaran ke folder public/payments
    $fileName = time() . '_' . $request->file('payment_proof')->getClientOriginalName();
    $request->file('payment_proof')->move(public_path('payments'), $fileName);

    DB::beginTransaction();
    try {
        // Buat data pembayaran dengan status 'pending'
        Payment::create([
            'order_id' => $orderId,
            'payment_proof' => 'payments/' . $fileName,
            'status' => Payment::STATUS_PENDING,
            'pending_at' => now(),
        ]);

        // Perbarui status pesanan menjadi 'pending_payment'
        $order->update([
            'status' => Order::STATUS_PENDING_PAYMENT,
            'pending_payment_at' => now(),
        ]);

        DB::commit();

        return back()->with('success', 'Bukti pembayaran berhasil dikirim. Mohon tunggu proses verifikasi.');
        
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal mengirim bukti pembayaran: ' . $e->getMessage());
    }
}



        // Customer marks order as complete
    public function completeOrder($orderId)
        {
            $order = Order::find($orderId);
        
            // Periksa apakah pesanan ditemukan
            if (!$order) {
                return back()->with('error', 'Order not found.');
            }
        
            // Set status order menjadi completed dengan menggunakan setStatus
            $order->setStatus(Order::STATUS_DELIVERED);
        
            return back()->with('success', 'Order marked as completed.');
        }
        

    // Cancel the order
    public function cancelOrder($orderId)
    {
        $order = Order::find($orderId);
    
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }
    
        // Status yang diperbolehkan untuk pembatalan
        $allowedStatuses = ['waiting_approval', 'approved', 'pending_payment', 'confirmed', 'processing'];
    
        if (!in_array($order->status, $allowedStatuses)) {
            return redirect()->back()->with('error', 'You cannot cancel this order in its current status.');
        }
    
        // Loop through order items to restore stock
        foreach ($order->orderItems as $item) {
            $product = $item->product;
    
            if ($product) {
                $product->update([
                    'stock' => $product->stock + $item->quantity
                ]);
            }
        }
    
        // Update order status to 'cancelled'
        $order->update(['status' => 'cancelled']);
    
        return redirect()->back()->with('success', 'Order has been cancelled and stock has been restored successfully.');
    }
    
    

    public static function generateInvoiceNumber()
    {
        // Format untuk tahun dan bulan
        $yearMonth = date('Ym'); 
        
        // Ambil nomor terakhir di bulan ini dari database
        $lastOrder = DB::table('t_orders')
        ->whereRaw('YEAR(created_at) = ?', [date('Y')])
        ->whereRaw('MONTH(created_at) = ?', [date('m')])
        ->orderBy('invoice_number', 'desc')
        ->first();

        // Tentukan nomor urut baru
        if ($lastOrder) {
            // Jika sudah ada order di bulan ini, ambil angka terakhir dari nomor invoice dan tambahkan 1
            $lastInvoiceNumber = intval(substr($lastOrder->invoice_number, -4));
            $nextInvoiceNumber = str_pad($lastInvoiceNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada order di bulan ini, mulai dari 0001
            $nextInvoiceNumber = '0001';
        }

        // Gabungkan format untuk nomor invoice
        return 'INV/' . $yearMonth . '/' . $nextInvoiceNumber;
    }

    public function generateInvoice($id)
    {
        $order = Order::with(['items.product', 'user.addresses'])->findOrFail($id);

        // Check if the order is approved before generating the invoice
        if (!in_array($order->status, ['approved', 'pending_payment', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])) {
            return redirect()->back()->with('error', 'Invoice can only be generated for approved, packing, shipped, or completed orders.');
        }
    
        // Generate invoice number if not already generated
        if (!$order->invoice_number) {
            $order->invoice_number = Order::generateInvoiceNumber();
            $order->save();
        }

        // Retrieve the e-commerce name from the parameter
        $parameter = Parameter::first(); // Assuming there's only one record

        // Sanitize invoice_number to remove any slashes or backslashes
        $invoice_number = str_replace(['/', '\\'], '-', $order->invoice_number);

        // Remove spaces from the e-commerce name
        $nama_ecommerce = str_replace(' ', '', $parameter->nama_ecommerce);

        // Set the invoice filename with the sanitized invoice number and e-commerce name
        $filename = $nama_ecommerce . '_' . $invoice_number . '.pdf';

        $pdf = PDF::loadView('customer.order.invoice', compact('order', 'parameter'));

        // Download the PDF file with the sanitized invoice number as the filename
        return $pdf->download($filename);
    }






}

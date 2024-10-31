<?php

namespace App\Http\Controllers\Customer\Order;

use App\Http\Controllers\Controller;
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

        // Get the status filter from the request
        $status = $request->input('status');
    
        // Fetch orders based on the status filter
        $orders = Order::where('user_id', auth()->id()) // Fetch only user's orders
                        ->when($status && $status !== 'semua', function ($query) use ($status) {
                            $query->where('status', $status);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();
    
            // Count orders with the 'approved' status (Menunggu Pembayaran)
        $waitingForPaymentCount = Order::where('user_id', auth()->id())
        ->where('status', 'pending_payment')
        ->count();
        
        return view('customer.settings.order.index', compact('orders', 'status','user', 'waitingForPaymentCount'));
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
            if ($item->quantity > $item->product->stock) {
                return redirect()->back()->with('error', "Product {$item->product->name} is out of stock.");
            }
        }

        // Mulai transaksi database
        DB::beginTransaction();
        try {
            // Hitung total
            $total = $cartItems->sum(function ($item) {
                return $item->quantity * ($item->product->discount_price ?? $item->product->price);
            });

            // Buat pesanan
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => Order::STATUS_WAITING_APPROVAL, // gunakan konstanta untuk status
                'waiting_approval_at' => now(),
            ]);

            // Tambahkan item ke pesanan
            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->discount_price ?? $item->product->price,
                    'total' => $item->quantity * ($item->product->discount_price ?? $item->product->price),
                ]);

                // Kurangi stok produk
                $item->product->decrement('stock', $item->quantity);
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
    // Find the order
    $order = Order::find($orderId);

    // Check if the order is cancelled
    if ($order->status === Order::STATUS_CANCELLED_BY_SYSTEM) {
        return back()->with('info', 'Your order has been cancelled due to non-payment.');
    }

    // Validate the payment proof
    $request->validate([
        'payment_proof' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // Store the payment proof in public/payments
    $fileName = time() . '_' . $request->file('payment_proof')->getClientOriginalName();
    $request->file('payment_proof')->move(public_path('payments'), $fileName);


    DB::beginTransaction();
    try {
        // Buat data pembayaran dengan status 'pending'
        Payment::create([
            'order_id' => $orderId,
            'payment_proof' => 'payments/' . $fileName,
            'status' => Payment::STATUS_PENDING,
            'peding_at' => now(),
        ]);

        // Perbarui status pesanan menjadi 'pending_payment'
        $order->update([
            'status' => Order::STATUS_PENDING_PAYMENT,
            'pending_payment_at' => now(),
        ]);

        DB::commit();

        return back()->with('success', 'Payment proof submitted. Awaiting verification.');
        
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Failed to submit payment proof: ' . $e->getMessage());
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

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'You cannot cancel this order.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Order has been cancelled successfully.');
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
        $order = Order::with('items.product')->findOrFail($id);

        // Check if the order is approved before generating the invoice
        if (!in_array($order->status, ['approved', 'pending_payment', 'confirmed', 'processing','shipped','delivered','cancelled'])) {
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

        $pdf = PDF::loadView('customer.order.invoice', compact('order'));

        // Download the PDF file with the sanitized invoice number as the filename
        return $pdf->download($filename);
    }






}

<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Customer\Order\OrderController;
use App\Models\Complaint;
use App\Models\Negotiation;
use App\Models\Order;
use App\Models\Parameter;
use App\Models\Payment;
use App\Models\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderHandleController extends Controller
{

    public function orders(Request $request)
    {
        // Query untuk List Orders
        $listQuery = Order::with('user')->orderBy('created_at', 'desc');
    
        // Filter untuk Daftar Pesanan (List)
        if ($request->input('search')) {
            $search = $request->input('search');
            $listQuery->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%");
            })->orWhere('invoice_number', 'like', "%{$search}%");
        }
    
        if ($request->input('invoice')) {
            $invoiceInput = $request->input('invoice');
            if (is_numeric($invoiceInput) && strlen($invoiceInput) === 4) {
                $listQuery->whereRaw('RIGHT(invoice_number, 4) = ?', [$invoiceInput]);
            } elseif (is_numeric($invoiceInput) && strlen($invoiceInput) === 6) {
                $listQuery->where('invoice_number', 'like', $invoiceInput . '%');
            } else {
                $listQuery->where('invoice_number', $invoiceInput);
            }
        }
    
        if ($request->input('total_range')) {
            switch ($request->input('total_range')) {
                case 'less_1m':
                    $listQuery->where('total', '<', 1000000);
                    break;
                case '1m_5m':
                    $listQuery->whereBetween('total', [1000000, 5000000]);
                    break;
                case '5m_10m':
                    $listQuery->whereBetween('total', [5000000, 10000000]);
                    break;
                case '10m_up':
                    $listQuery->where('total', '>', 10000000);
                    break;
            }
        }
    
        if ($request->input('status') && $request->input('status') != 'all') {
            $listQuery->where('status', $request->input('status'));
        }
    
        // Paginate hasil untuk List Orders
        $orders = $listQuery->paginate(10);
    
        // Query untuk Chart Orders
        $chartQuery = Order::orderBy('created_at', 'desc');
    
        // Filter untuk Grafik Pesanan (Chart)
        $chartStatus = $request->input('chart_status', 'all'); // Default: all
        if ($chartStatus !== 'all') {
            $chartQuery->where('status', $chartStatus);
        }
    
        // Filter rentang tanggal (from_date dan to_date)
        if ($request->input('from_date') && $request->input('to_date')) {
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            $chartQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }
    
        // Ambil hasil untuk Chart
        $chartOrders = Order::with('user')->get();
    
        $shipping = ShippingService::all();
    
        return view('admin.order.index', compact('orders', 'chartOrders', 'shipping', 'chartStatus'));
    }
    




    public function payments(Request $request)
    {
        // Create a query for payments
        $query = Payment::with('order.user')->orderBy('created_at', 'desc');
    
        // Search by customer name
        if ($request->input('name')) {
            $name = $request->input('name');
            $query->whereHas('order.user', function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%")
                  ->orWhere('full_name', 'like', "%{$name}%");
            });
        }
    
        // Search by invoice number
        if ($request->input('invoice_number')) {
            $invoice = $request->input('invoice_number');
            $query->whereHas('order', function ($q) use ($invoice) {
                $q->where('invoice_number', 'like', "%{$invoice}%");
            });
        }
    
        // Filter by payment status
        if ($request->input('status') && $request->input('status') != 'all') {
            $query->where('status', $request->input('status'));
        }
    
        // Paginate the result
        $payments = $query->paginate(10);
    
        return view('admin.payment.index', compact('payments'));
    }
    

    public function showOrders($id)
    {
        $order = Order::with('user.addresses', 'items')->findOrFail($id);
        
        // Mark the order as viewed
        if (!$order->is_viewed) {
            $order->is_viewed = true; // Set is_viewed to true
            $order->save(); // Save the change to the database
        }
    
        $shipping = ShippingService::all(); // Fetch shipping services
        return view('admin.order.show', compact('order', 'shipping'));
    }

    public function showPayment($paymentId)
    {
        // Fetch the payment by ID, along with the associated order and user
        $payment = Payment::with('order.user')->findOrFail($paymentId);
        
        if (!$payment->is_viewed) {
            $payment->is_viewed = true; // Set is_viewed to true
            $payment->save(); // Save the change to the database
        }

        // Return the view with payment details
        return view('admin.payment.show', compact('payment'));
    }

    


    // Admin approval of order
    public function approveOrder($orderId)
    {
        // Temukan pesanan berdasarkan ID
        $order = Order::find($orderId);
        $parameter = Parameter::first();

        // Periksa apakah pesanan ditemukan
        if (!$order) {
            return back()->with('error', 'Order not found.');
        }

        // Periksa apakah pesanan sudah disetujui
        if ($order->status === Order::STATUS_APPROVED) {
            return back()->with('error', 'This order has already been approved.');
        }

        if (!$parameter || !$parameter->bank_vendor || !$parameter->bank_nama || !$parameter->bank_rekening) {
            return back()->with('error', 'Maaf, pesanan tidak dapat disetujui karena informasi bank belum lengkap. Silakan lengkapi data bank pada menu Master Data -> Parameter.');
        }
        

        DB::beginTransaction();
        try {
            // Buat nomor faktur jika belum ada
            if (!$order->invoice_number) {
                $order->invoice_number = OrderController::generateInvoiceNumber();
            }

            // Perbarui status dan waktu persetujuan
            $order->update([
                'status' => Order::STATUS_APPROVED,
                'approved_at' => now(),
            ]);

            DB::commit();
            return back()->with('success', 'Order approved successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve the order: ' . $e->getMessage());
        }
    }

    public function allowPayment($orderId)
    {
        // Temukan pesanan berdasarkan ID
        $order = Order::find($orderId);

        // Periksa apakah pesanan ditemukan dan apakah statusnya sudah disetujui
        if (!$order || $order->status !== Order::STATUS_APPROVED) {
            return back()->with('error', 'Order not eligible for payment.');
        }

        try {
            // Ubah status pesanan menjadi 'pending_payment'
            $order->update([
                'status' => Order::STATUS_PENDING_PAYMENT,
                'pending_payment_at' => now(),
            ]);

            // Redirect customer ke halaman pembayaran
            return back()->with('success', 'Access Payment approved successfully.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to proceed to payment: ' . $e->getMessage());
        }
    }
    

    // Handle payment verification by admin
    public function verifyPayment($paymentId)
    {
        $payment = Payment::find($paymentId);

        // Periksa apakah pembayaran ditemukan
        if (!$payment) {
            return back()->with('error', 'Payment not found.');
        }

        // Perbarui status pembayaran menjadi 'paid' dan tandai sebagai dilihat
        $payment->update([
            'status' => Payment::STATUS_PAID,
            'paid_at' => now(),
            'is_viewed' => true,
        ]);

        // Perbarui status pesanan terkait menjadi 'confirmed' dan catat waktu verifikasi pembayaran
        $order = $payment->order;
        $order->update([
            'status' => Order::STATUS_CONFIRMED,
            'payment_verified_at' => now(),
        ]);

        return back()->with('success', 'Payment verified successfully.');
    }

    public function rejectPayment($paymentId)
    {
        // Temukan pembayaran berdasarkan ID
        $payment = Payment::find($paymentId);

        // Periksa apakah pembayaran ditemukan
        if (!$payment) {
            return back()->with('error', 'Payment not found.');
        }

        // Perbarui status pembayaran menjadi 'failed'
        $payment->update([
            'status' => Payment::STATUS_FAILED,
            'is_viewed' => true,
        ]);

        $order = $payment->order;

        // Cek jumlah pembayaran gagal pada pesanan terkait
        $failedPaymentsCount = $order->payments()->where('status', Payment::STATUS_FAILED)->count();

        if ($failedPaymentsCount >= 2) {
            // Jika jumlah gagal mencapai 2, batalkan pesanan secara otomatis
            $order->update([
                'status' => Order::STATUS_CANCELLED_BY_SYSTEM,
                'cancelled_by_system_at' => now(),
            ]);

            foreach ($order->items as $item) { // Asumsi ada relasi 'items' pada model Order
                $product = $item->product; // Asumsi ada relasi 'product' pada model OrderItem
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }


            return back()->with('error', 'Payment rejected and order cancelled due to multiple failed attempts.');
        }

        return back()->with('warning', 'Payment rejected. You may resubmit your payment proof one more time.');
    }


    // Admin marks order as packing
    public function markAsPacking($orderId)
    {
        // Temukan pesanan berdasarkan ID
        $order = Order::find($orderId);

        // Periksa apakah pesanan ditemukan dan statusnya adalah 'processing'
        if (!$order || $order->status !== Order::STATUS_CONFIRMED) {
            return back()->with('error', 'Order is not eligible for packing.');
        }

        // Perbarui status dan catat timestamp
        $order->update([
            'status' => Order::STATUS_PROCESSING, // gunakan konstanta status
            'packing_at' => now(),              // Set packing timestamp
            'processing_at' => now(),           // Set processing timestamp
        ]);

        return back()->with('success', 'Order is now in the packing process.');
    }

    // Admin marks order as shipped and adds tracking number
    public function markAsShipped(Request $request, $orderId)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:255',
            'shipping_service_id' => 'required|exists:t_md_shipping_services,id', // Ensure the shipping service exists
        ]);

        $order = Order::find($orderId);
        $order->update([
            'status' => 'shipped',
            'tracking_number' => $request->tracking_number,
            'shipping_service_id' => $request->shipping_service_id, // Save the selected shipping service
            'shipped_at' => now() // Set shipped timestamp
        ]);

        return back()->with('success', 'Order marked as shipped.');
    }

    public function MarkAsCompleted($orderId)
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

    public function cancelOrder(Request $request, $orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);

        if ($order->status !== Order::STATUS_CANCELLED && $order->status !== Order::STATUS_CANCELLED_BY_ADMIN) {
            // Kembalikan jumlah quantity setiap produk ke stok
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->stock += $item->quantity; // Kembalikan jumlah ke stok produk
                    $product->save();
                }
            }

            // Set status pesanan ke 'cancelled_by_admin'
            $order->status = Order::STATUS_CANCELLED_BY_ADMIN;
            $order->cancelled_by_admin_at = now(); // Set timestamp cancelled_by_admin
            $order->save();

            return redirect()->back()->with('success', 'Order has been cancelled by the admin, and stock has been updated.');
        }

        return redirect()->back()->with('error', 'Order has already been cancelled.');
    }


    
}

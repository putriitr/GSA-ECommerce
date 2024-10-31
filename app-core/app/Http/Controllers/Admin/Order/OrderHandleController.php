<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Customer\Order\OrderController;
use App\Models\Complaint;
use App\Models\Negotiation;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderHandleController extends Controller
{

    public function orders(Request $request)
    {
        $query = Order::with('user')->orderBy('created_at', 'desc');

        // Search by customer name or invoice number
        if ($request->input('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('full_name', 'like', "%{$search}%");
            })->orWhere('invoice_number', 'like', "%{$search}%");
        }

        // Filter by invoice number
        if ($request->input('invoice')) {
            $invoiceInput = $request->input('invoice');
            
            // Check if the input is numeric and 4 digits long (for last 4 digits filtering)
            if (is_numeric($invoiceInput) && strlen($invoiceInput) === 4) {
                // Filter by the last 4 digits of the invoice number
                $query->whereRaw('RIGHT(invoice_number, 4) = ?', [$invoiceInput]);
            } 
            // Check if the input is year and month (e.g., 202410)
            elseif (is_numeric($invoiceInput) && strlen($invoiceInput) === 6) {
                // Filter by the year and month in the invoice number
                $query->where('invoice_number', 'like', $invoiceInput . '%');
            } 
            // Fallback to filtering by the entire invoice number
            else {
                $query->where('invoice_number', $invoiceInput);
            }
        }

        // Filter by total range
        if ($request->input('total_range')) {
            switch ($request->input('total_range')) {
                case 'less_1m':
                    $query->where('total', '<', 1000000);
                    break;
                case '1m_5m':
                    $query->whereBetween('total', [1000000, 5000000]);
                    break;
                case '5m_10m':
                    $query->whereBetween('total', [5000000, 10000000]);
                    break;
                case '10m_up':
                    $query->where('total', '>', 10000000);
                    break;
            }
        }

        // Filter by status
        if ($request->input('status') && $request->input('status') != 'all') {
            $query->where('status', $request->input('status'));
        }

        // Paginate the result
        $orders = $query->paginate(10);
        
        $shipping = ShippingService::all();
        
        return view('admin.order.index', compact('orders', 'shipping'));
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

        // Periksa apakah pesanan ditemukan
        if (!$order) {
            return back()->with('error', 'Order not found.');
        }

        // Periksa apakah pesanan sudah disetujui
        if ($order->status === Order::STATUS_APPROVED) {
            return back()->with('error', 'This order has already been approved.');
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

    public function cancelOrder(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
    
        if ($order->status !== Order::STATUS_CANCELLED && $order->status !== Order::STATUS_CANCELLED_BY_ADMIN) {
            // Set the status to 'cancelled_by_admin'
            $order->status = Order::STATUS_CANCELLED_BY_ADMIN;
            $order->cancelled_by_admin_at = now(); // Set the cancelled_by_admin timestamp
            $order->save();
    
            return redirect()->back()->with('success', 'Order has been cancelled by the admin.');
        }
    
        return redirect()->back()->with('error', 'Order has already been cancelled.');
    }
    
}
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
        $order = Order::find($orderId);

        // Check if the order is not already approved
    if ($order->status == 'approved') {
        return back()->with('error', 'This order has already been approved.');
    }

    // Generate the invoice number if not already generated
    if (!$order->invoice_number) {
        $order->invoice_number = OrderController::generateInvoiceNumber();
    }

        $order->update([
            'status' => 'approved',
            'approved_at' => now() // Set the approved timestamp
        ]);
    
        return back()->with('success', 'Order approved successfully.');
    }
    

    // Handle payment verification by admin
    public function verifyPayment($paymentId)
    {
        $payment = Payment::find($paymentId);

        // Check if the payment exists before proceeding
        if (!$payment) {
            return back()->with('error', 'Payment not found.');
        }

        // Update the payment status
        $payment->update(['status' => 'approved', 'is_viewed' => true]); // Mark as viewed when verifying

        // Mark the associated order as 'payment_verified'
        $order = $payment->order;
        $order->update([
            'status' => 'payment_verified',
            'payment_verified_at' => now() // Set payment verified timestamp
        ]);

        return back()->with('success', 'Payment verified successfully.');
    }

    public function rejectPayment($paymentId)
{
    // Find the payment by ID
    $payment = Payment::find($paymentId);

    // Check if the payment exists before proceeding
    if (!$payment) {
        return back()->with('error', 'Payment not found.');
    }

    // Update the payment status to 'rejected' and mark as viewed
    $paymentUpdated = $payment->update(['status' => 'rejected', 'is_viewed' => true]); // Mark as viewed when rejecting

    // Check if the update was successful
    if (!$paymentUpdated) {
        return back()->with('error', 'Failed to update payment status.');
    }

    // Update the associated order status to 'cancelled_by_system'
    $order = $payment->order; // Assuming there's a relationship defined in the Payment model
    if ($order) {
        $orderUpdated = $order->update([
            'status' => 'cancelled_by_system', // Ensure this value is valid in your database schema
            'cancelled_at' => now() // Optional: you can also track when it was cancelled
        ]);

        // Check if the order update was successful
        if (!$orderUpdated) {
            return back()->with('error', 'Failed to update order status.');
        }
    }

    return back()->with('success', 'Payment rejected successfully and order status updated.');
}


    



    // Admin marks order as packing
    public function markAsPacking($orderId)
    {
        $order = Order::find($orderId);
        $order->update([
            'status' => 'packing',
            'packing_at' => now() // Set packing timestamp
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

        if ($order->status !== 'cancelled' && $order->status !== 'cancelled_by_system') {
            // Set the status to 'cancelled_by_system'
            $order->status = 'cancelled_by_system';
            $order->save();

            return redirect()->back()->with('success', 'Order has been cancelled by the system.');
        }

        return redirect()->back()->with('error', 'Order has already been cancelled.');
    }
}

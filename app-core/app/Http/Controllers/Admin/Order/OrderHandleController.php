<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Negotiation;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ShippingService;
use Illuminate\Http\Request;

class OrderHandleController extends Controller
{

    public function orders()
    {
        // Fetch all orders for the admin to review
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        $shipping = ShippingService::all();
        return view('admin.order.index', compact('orders','shipping'));
    }


    public function payments()
    {
        // Fetch all payments for the admin to review
        $payments = Payment::with('order.user')->orderBy('created_at', 'desc')->get();
        return view('admin.payment.index', compact('payments'));
    }

    // Admin approval of order
    public function approveOrder($orderId)
    {
        $order = Order::find($orderId);
        $order->update(['status' => 'approved']);
    
        return back()->with('success', 'Order approved successfully.');
    }

    // Handle payment verification by admin
    public function verifyPayment($paymentId)
    {
        $payment = Payment::find($paymentId);
        $payment->update(['status' => 'approved']);
    
        // Mark the order as 'payment_verified'
        $order = $payment->order;
        $order->update(['status' => 'payment_verified']);
    
        return back()->with('success', 'Payment verified successfully.');
    }

    // Admin marks order as packing
    public function markAsPacking($orderId)
    {
        $order = Order::find($orderId);
        $order->update(['status' => 'packing']);

        return back()->with('success', 'Order is now in packing process.');
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
        ]);

        return back()->with('success', 'Order marked as shipped.');
    }


    // Handle complaints
    public function handleComplaint($complaintId)
    {
        $complaint = Complaint::find($complaintId);
        $complaint->update(['status' => 'resolved']);

        return back()->with('success', 'Complaint resolved successfully.');
    }

    // Manage negotiation
    public function handleNegotiation($orderId, Request $request)
    {
        $order = Order::find($orderId);

        if ($request->accept_negotiation) {
            $negotiation = Negotiation::create([
                'order_id' => $orderId,
                'user_id' => $order->user_id,
                'status' => 'accepted',
                'negotiated_price' => $request->negotiated_price,
            ]);

            $order->update(['status' => 'negotiated']);
        } else {
            $order->update(['status' => 'negotiation_failed']);
        }

        return back()->with('success', 'Negotiation handled successfully.');
    }
}

<?php

namespace App\Http\Controllers\Customer\Order;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Http\Request;
use PDF; 

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
        ->where('status', 'approved')
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

        // Calculate total
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * ($item->product->discount_price ?? $item->product->price);
        });

        // Create the order
        $order = Order::create([
            'user_id' => $user->id,
            'total' => $total,
            'status' => 'pending', // default status is pending
        ]);

        // Attach items to the order
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->discount_price ?? $item->product->price,
                'total' => $item->quantity * ($item->product->discount_price ?? $item->product->price),
            ]);
        }

        // Clear cart after checkout
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('customer.order.show', $order->id)->with('success', 'Checkout completed.');
    }


    // Submit payment proof
    public function submitPaymentProof(Request $request, $orderId)
    {
        // Validate the payment proof
        $request->validate([
            'payment_proof' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Store the payment proof in public/payments
        $fileName = time() . '_' . $request->file('payment_proof')->getClientOriginalName();
        $request->file('payment_proof')->move(public_path('payments'), $fileName);

        // Save the payment details
        Payment::create([
            'order_id' => $orderId,
            'payment_proof' => 'payments/' . $fileName,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Payment proof submitted. Awaiting verification.');
    }

        // Customer marks order as complete
    public function completeOrder($orderId)
    {
        $order = Order::find($orderId);
        $order->update(['status' => 'completed']);

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

    public function generateInvoice($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        // Check if the order is approved before generating the invoice
        if ($order->status != 'approved') {
            return redirect()->back()->with('error', 'The invoice can only be generated for approved orders.');
        }

        $pdf = PDF::loadView('customer.order.invoice', compact('order'));

        // Download the PDF file
        return $pdf->download('invoice_order_' . $order->id . '.pdf');
    }

}

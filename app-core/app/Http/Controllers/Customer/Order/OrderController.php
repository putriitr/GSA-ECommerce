<?php

namespace App\Http\Controllers\Customer\Order;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Checkout - Create an order
    public function checkout(Request $request)
    {
        $user = auth()->user();
        $cartItems = Cart::where('user_id', $user->id)->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // Calculate total amount and process order creation
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * ($item->product->discount_price ?? $item->product->price);
        });

        // Create the order
        $order = Order::create([
            'user_id' => $user->id,
            'total' => $total,
            'status' => 'pending', // default status is pending
        ]);

        // Attach each cart item to the order
        foreach ($cartItems as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->discount_price ?? $cartItem->product->price,
                'total' => $cartItem->quantity * ($cartItem->product->discount_price ?? $cartItem->product->price),
            ]);
        }

        // Clear the cart after checkout
        Cart::where('user_id', $user->id)->delete();

        // Notify the admin for review and approval
        // (You could send a notification here or implement event listeners)

        return redirect()->route('customer.order.show', $order->id)->with('success', 'Checkout completed. Please wait for admin approval.');
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

        // Update the order status to 'payment_submitted'
        $order = Order::find($orderId);
        $order->update(['status' => 'payment_submitted']);

        return back()->with('success', 'Payment proof submitted. Awaiting verification.');
    }

        // Customer marks order as complete
        public function completeOrder($orderId)
        {
            $order = Order::find($orderId);
            $order->update(['status' => 'completed']);
    
            return back()->with('success', 'Order marked as completed.');
        }


        // Show the customer's order
    public function showOrder($orderId)
    {
        $order = Order::find($orderId);
        return view('customer.order.show', compact('order'));
    }

    public function cancelOrder($orderId)
    {
        $order = Order::find($orderId);

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'You cannot cancel this order.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Order has been cancelled successfully.');
    }



}

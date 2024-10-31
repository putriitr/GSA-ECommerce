<?php

namespace App\Http\Controllers\Customer\Review;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewCustomerController extends Controller
{
    public function createReview(Request $request, $productId)
    {
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)
            ->where('status', Order::STATUS_DELIVERED) // Gunakan status 'delivered'
            ->whereHas('items', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->first();


        if (!$order) {
            return redirect()->back()->with('error', 'You are not eligible to review this product.');
        }

        // Check if the user already reviewed this product for this order
        $existingReview = Review::where('user_id', $user->id)
                                ->where('product_id', $productId)
                                ->where('order_id', $order->id)
                                ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this product for this order.');
        }

        return view('reviews.create', compact('productId', 'order'));
    }

    public function storeReview(Request $request)
{
    $validated = $request->validate([
        'product_id' => 'required|exists:t_product,id',
        'order_id' => 'required|exists:t_orders,id',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:500',
    ]);

    // Retrieve the specific order based on the order ID and other conditions
    $order = Order::where('id', $validated['order_id'])
              ->where('user_id', auth()->id())
              ->where('status', Order::STATUS_DELIVERED) // Ganti 'completed' menjadi 'delivered'
              ->first();


    if (!$order) {
        return response()->json(['errors' => ['You do not have a completed order for this product.']], 422);
    }

    // Create the review for the specific order
    $review = Review::create([
        'user_id' => auth()->id(),
        'product_id' => $validated['product_id'],
        'order_id' => $validated['order_id'],
        'rating' => $validated['rating'],
        'comment' => $validated['comment'],
    ]);

    // Return the review details as a JSON response
    return response()->json([
        'success' => true,
        'message' => 'Thank you for your review!',
        'review' => [
            'created_at' => $review->created_at->format('F d, Y'),
            'name' => $review->user->name,
            'rating' => $review->rating,
            'comment' => $review->comment,
            'profile_photo' => asset($review->user->profile_photo)
        ]
    ]);
}





}

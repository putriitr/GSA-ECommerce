<?php

namespace App\Http\Controllers\Customer\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductMemberController extends Controller
{
    public function show($slug)
    {
        // Find the product by its slug and eager load its images
        $product = Product::with('images')->where('slug', $slug)->firstOrFail();

        $categories = Category::with('products')->get(); 

        $randomProducts = Product::where('status_published', 'published')
        ->whereNull('discount_price')  
        ->inRandomOrder()
        ->take(6)
        ->get();

        $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->where('status_published', 'Published') // Menambahkan filter status published
        ->take(8)
        ->get();

        $reviews = $product->reviews()->with('user')->get();

        $orders = Order::where('user_id', auth()->id())
        ->where('status', 'completed')
        ->whereHas('items', function ($query) use ($product) {
            $query->where('product_id', $product->id);
        })
        ->get();

        // Get order IDs that already have reviews for this product
        $reviewedOrderIds = Review::where('user_id', auth()->id())
        ->where('product_id', $product->id)
        ->pluck('order_id')
        ->toArray();

        $averageRating = $product->reviews()->avg('rating');
    

        return view('customer.product.show', compact('product', 'categories', 'randomProducts', 'relatedProducts', 'reviews', 'orders', 'reviewedOrderIds', 'averageRating'));
    }

}

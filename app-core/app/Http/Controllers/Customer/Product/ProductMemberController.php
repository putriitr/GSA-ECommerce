<?php

namespace App\Http\Controllers\Customer\Product;

use App\Http\Controllers\Controller;
use App\Models\BigSale;
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

        // Get all categories with their products
        $categories = Category::with('products')->get(); 

        // Get the active Big Sale
        $bigSales = BigSale::where('status', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->first();

        // Get the product IDs that are part of the active Big Sale
        $bigSaleProductIds = $bigSales ? $bigSales->products->pluck('id')->toArray() : [];

        // Get random products, excluding those in the active Big Sale
        $randomProducts = Product::where('status_published', 'published')
            ->whereNull('discount_price')  
            ->whereNotIn('id', $bigSaleProductIds) // Exclude products already in Big Sale
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Get related products, excluding those in the active Big Sale
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status_published', 'Published') // Ensure product is published
            ->whereNotIn('id', $bigSaleProductIds) // Exclude products already in Big Sale
            ->take(8)
            ->get();

        // Get reviews for the current product
        $reviews = $product->reviews()->with('user')->get();

        // Get orders where this product was purchased by the current user
        $orders = Order::where('user_id', auth()->id())
            ->where('status', 'delivered')
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->get();

        // Get order IDs that already have reviews for this product
        $reviewedOrderIds = Review::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->pluck('order_id')
            ->toArray();

        // Calculate the average rating of the product
        $averageRating = $product->reviews()->avg('rating');

        // Pass all the data to the view
        return view('customer.product.show', compact(
            'product', 
            'categories', 
            'randomProducts', 
            'relatedProducts', 
            'reviews', 
            'orders', 
            'reviewedOrderIds', 
            'averageRating',
            'bigSales'
        ));
    }
}

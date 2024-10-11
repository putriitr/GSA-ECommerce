<?php

namespace App\Http\Controllers\Customer\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
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
    

        return view('customer.product.show', data: compact('product','categories','randomProducts','relatedProducts'));
    }

}

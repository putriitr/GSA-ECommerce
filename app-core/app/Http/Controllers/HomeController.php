<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Parameter;
use App\Models\Product;
use App\Models\Service;
use App\Models\Category;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get only categories that have products with status_published as 'published'
        $categories = Category::whereHas('products', function($query) {
            $query->where('status_published', 'published');
        })->get();
    
        // Get only products that are published
        $products = Product::where('status_published', 'published')->get();
    
        return view('customer.home.home', compact('categories', 'products'));
    }
    

    public function filterByCategory(Request $request)
    {
        if ($request->slug === 'all') {
            // Show all products that are published
            $products = Product::where('status_published', 'published')->get();
        } else {
            // Get the category by slug
            $category = Category::where('slug', $request->slug)->first();
            
            // Check if the category exists to avoid errors
            if ($category) {
                // Fetch products from the selected category and with status 'published'
                $products = Product::where('category_id', $category->id)
                                   ->where('status_published', 'published')
                                   ->get();
            } else {
                // If no category found, return an empty collection or an error message
                $products = collect();
            }
        }
    
        return response()->json($products);
    }
    
 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view('admin.dashboard.dashboard');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function managerHome()
    {
        return view('managerHome');
    }


    

}

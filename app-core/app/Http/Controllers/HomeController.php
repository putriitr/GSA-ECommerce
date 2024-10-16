<?php

namespace App\Http\Controllers;

use App\Models\BannerHome;
use App\Models\Slider;
use App\Models\Parameter;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Service;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Get only categories that have products with status_published as 'published'
        $categories = Category::whereHas('products', function($query) {
            $query->where('status_published', 'published');
        })->get();

        // Get only products that are published and include their completed order count
        $products = Product::withCount(['orderItems as completed_order_count' => function($query) {
            $query->whereHas('order', function($query) {
                $query->where('status', 'completed');
            });
        }])->where('status_published', 'published')->limit(12)->get();
        
        // Best-selling products query
        $bestsellerProducts = Product::select('t_product.id', 't_product.name', 't_product.price', 't_product.discount_price', 't_product.slug', 't_product.category_id', 't_product.status_published', DB::raw('SUM(t_ord_items.quantity) as total_quantity'))
            ->join('t_ord_items', 't_product.id', '=', 't_ord_items.product_id')
            ->join('t_orders', 't_ord_items.order_id', '=', 't_orders.id')
            ->where('t_orders.status', 'completed')
            ->groupBy('t_product.id', 't_product.name', 't_product.price', 't_product.discount_price', 't_product.slug', 't_product.category_id', 't_product.status_published')
            ->orderByRaw('total_quantity DESC')
            ->limit(6)
            ->get();

        $banners = BannerHome::where('active', 1)->orderBy('order')->get();


        return view('customer.home.home', compact('categories', 'products', 'bestsellerProducts','banners'));
    }

    public function filterByCategory(Request $request)
    {
        if ($request->slug === 'all') {
            // Fetch all published products with related images, reviews, and completed order count
            $products = Product::with(['images', 'reviews'])
                                ->withCount(['orderItems as completed_order_count' => function($query) {
                                    $query->whereHas('order', function($query) {
                                        $query->where('status', 'completed');
                                    });
                                }])
                                ->where('status_published', 'published')
                                ->get();
        } else {
            $category = Category::where('slug', $request->slug)->first();
            
            if ($category) {
                // Fetch products from the selected category with published status
                $products = Product::with(['images', 'reviews'])
                                    ->withCount(['orderItems as completed_order_count' => function($query) {
                                        $query->whereHas('order', function($query) {
                                            $query->where('status', 'completed');
                                        });
                                    }])
                                    ->where('category_id', $category->id)
                                    ->where('status_published', 'published')
                                    ->get();
            } else {
                $products = collect();
            }
        }

        // Prepare the products data to send it as JSON response
        $formattedProducts = $products->map(function($product) {
            // Calculate average rating
            $averageRating = $product->reviews->avg('rating') ?? 0;

            return [
                'name' => $product->name,
                'price' => $product->price,
                'discount_price' => $product->discount_price,
                'stock' => $product->stock,
                'is_pre_order' => $product->is_pre_order,
                'image' => $product->images->isNotEmpty() ? asset($product->images->first()->image) : asset('assets/default/image/no-image.png'),
                'url' => route('customer.product.show', $product->slug),
                'average_rating' => number_format($averageRating, 1),
                'completed_order_count' => $product->completed_order_count, 
            ];
        });

        return response()->json($formattedProducts);
    }


    public function shop(Request $request)
{
    $sort = $request->get('sort', 'terbaru'); // Default sorting adalah 'terbaru'
    $categoryId = $request->get('category_id'); // Ambil ID kategori dari URL jika ada
    $keyword = $request->get('keyword'); // Ambil keyword pencarian

    // Konversi input 'min_price' dan 'max_price' dari string ke angka
    $minPrice = $request->get('min_price') ? intval(str_replace('.', '', $request->get('min_price'))) : null;
    $maxPrice = $request->get('max_price') ? intval(str_replace('.', '', $request->get('max_price'))) : null;

    $filterMessage = null; // Default tidak ada filter

    // Ambil kategori yang dipilih
    $selectedCategory = null;
    if ($categoryId) {
        $selectedCategory = Category::find($categoryId);
    }

    // Ambil kategori beserta jumlah produk yang dipublikasikan
    $categories = Category::withCount(['products' => function ($query) {
        $query->where('status_published', 'published');
    }])->get();

    // Mulai query untuk produk yang dipublikasikan
    $products = Product::where('status_published', 'published');

    // Terapkan filter keyword jika ada
    if ($keyword) {
        $products->where('name', 'LIKE', '%' . $keyword . '%');
    }

    // Terapkan filter harga hanya jika pengguna memasukkan nilai valid
    if ($minPrice !== null && $maxPrice !== null) {
        $products->whereBetween('price', [$minPrice, $maxPrice]);
    }

    // Terapkan filter kategori hanya jika pengguna memilih kategori
    if ($categoryId) {
        $products->where('category_id', $categoryId);
    }

    // Terapkan sorting berdasarkan pilihan pengguna
    switch ($sort) {
        case 'terbaru':
            $products->orderBy('created_at', 'desc');
            break;
        case 'terlama':
            $products->orderBy('created_at', 'asc');
            break;
        case 'termahal':
            $products->orderBy('price', 'desc');
            break;
        case 'termurah':
            $products->orderBy('price', 'asc');
            break;
    }

    // Eksekusi query untuk mendapatkan data produk
    $products = $products->paginate(16);

    // Menyusun pesan filter hanya jika ada kategori, filter harga, atau keyword
    if ($selectedCategory || ($minPrice !== null && $maxPrice !== null) || $keyword) {
        $filterMessage = 'Produk yang ditemukan: ';
        if ($selectedCategory) {
            $filterMessage .= 'kategori ' . $selectedCategory->name;
        }

        if ($minPrice !== null && $maxPrice !== null) {
            if ($selectedCategory) {
                $filterMessage .= ' dari ';
            }
            $filterMessage .= 'harga Rp' . number_format($minPrice, 0, ',', '.') . ' - Rp' . number_format($maxPrice, 0, ',', '.');
        }

        if ($keyword) {
            $filterMessage .= ' dengan keyword "' . $keyword . '"';
        }
    }

    return view('customer.home.shop', compact('products', 'categories', 'filterMessage'));
}







    
 
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

<?php

namespace App\Http\Controllers;

use App\Models\BannerHome;
use App\Models\Slider;
use App\Models\Parameter;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Service;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\TranslationHelper;
use App\Models\BigSale;
use App\Models\Payment;

class HomeController extends Controller
{
    public function index()
    {
        // Get only categories that have products with status_published as 'published'
        $categories = Category::whereHas('products', function($query) {
            $query->where('status_published', 'published');
        })->get();

        

       // Ambil Big Sale yang aktif
        $bigSaleActive = BigSale::where('status', true)
        ->where('start_time', '<=', now())
        ->where('end_time', '>=', now())
        ->first();
        
        $banners = BannerHome::where('active', 1)->orderBy('order')->get();

        $approvedOrders = Order::where('user_id', Auth::id())
            ->where('status', 'pending_payment')
            ->get();

        $bigSales = BigSale::where('status', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->first();

        $bigSaleProductIds = $bigSales ? $bigSales->products->pluck('id')->toArray() : [];

        $products = Product::with('images')
        ->where('status_published', 'published')
        ->whereNotIn('id', $bigSaleProductIds) // Kecualikan produk yang ada dalam Big Sale
        ->orderBy('created_at', 'desc') // Urutkan berdasarkan produk terbaru
        ->take(8) // Batas produk yang diambil sebanyak 8
        ->get();


        return view('customer.home.home', compact('categories', 'products','banners','approvedOrders','bigSales'));
    }

    public function filterByCategory(Request $request)
    {
        // Ambil Big Sale yang aktif
        $bigSaleActive = BigSale::where('status', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->first();

        $bigSales = BigSale::where('status', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->first();

        $bigSaleProductIds = $bigSales ? $bigSales->products->pluck('id')->toArray() : [];

        if ($request->slug === 'all') {
            // Fetch all published products with related images, reviews, and completed order count
            $products = Product::with(['images', 'reviews'])
                                ->withCount(['orderItems as completed_order_count' => function($query) {
                                    $query->whereHas('order', function($query) {
                                        $query->where('status', 'delivered');
                                    });
                                }])
                                ->whereNotIn('id', $bigSaleProductIds) // Kecualikan produk yang ada dalam Big Sale
                                ->where('status_published', 'published')
                                ->get();
        } else {
            $category = Category::where('slug', $request->slug)->first();
            
            if ($category) {
                // Fetch products from the selected category with published status
                $products = Product::with(['images', 'reviews'])
                                    ->withCount(['orderItems as completed_order_count' => function($query) {
                                        $query->whereHas('order', function($query) {
                                            $query->where('status', 'delivered');
                                        });
                                    }])
                                    ->where('category_id', $category->id)
                                    ->where('status_published', 'published')
                                    // Mengecualikan produk yang sudah terdaftar di Big Sale yang aktif
                                    ->whereDoesntHave('bigSales', function($query) use ($bigSaleActive) {
                                        if ($bigSaleActive) {
                                            $query->where('bigsale_id', $bigSaleActive->id);
                                        }
                                    })
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

        $bigSales = BigSale::where('status', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->first();

        $bigSaleProductIds = $bigSales ? $bigSales->products->pluck('id')->toArray() : [];
    
        // Eksekusi query untuk mendapatkan data produk
        $products = $products
        ->whereNotIn('id', $bigSaleProductIds) // Kecualikan produk yang ada dalam Big Sale
        ->paginate(16);
    
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
    
        return view('customer.home.shop', compact('products', 'categories', 'filterMessage', 'selectedCategory'));
    }
    







    
 
    public function dashboard()
    {
        // Load payments with their related orders, limited to 10, ordered by the latest
        $payments = Payment::with('order')
                            ->orderBy('created_at', 'desc')
                            ->paginate(5); // Paginate the payments, limit to 10

        // Load orders with users and payments, limited to 10, ordered by the latest
        $orders = Order::with('user', 'payments')
                        ->orderBy('created_at', 'desc')
                        ->paginate(5); // Paginate the orders, limit to 10

                        $parameter = Parameter::first();

                        // Check if bank details are missing
                        $missingBankDetails = false;
                        $missingDetailsMessage = '';
                    
                        if (!$parameter || !$parameter->bank_vendor || !$parameter->bank_nama || !$parameter->bank_rekening) {
                            $missingBankDetails = true;
                            $missingDetailsMessage = 'Harap lengkapi informasi bank (Vendor, Nama, dan Rekening) di pengaturan.';
                        }

                        $orderNotifications = [];
                        foreach ($orders as $order) {
                            $customerName = $order->user->name ?? $user->fullname ?? 'Tidak diketahui';
                            $invoiceNumber = $order->invoice_number ?? 'Tidak tersedia';
                        
                            switch ($order->status) {
                                case Order::STATUS_WAITING_APPROVAL:
                                    $orderNotifications[$order->id] = "Pesanan #{$order->id} (Pelanggan: {$customerName}): Pesanan ini sedang menunggu persetujuan Anda. Harap segera tinjau agar pelanggan tidak menunggu terlalu lama.";
                                    break;
                                case Order::STATUS_APPROVED:
                                    $orderNotifications[$order->id] = "Pesanan #{$order->id} (Invoice: {$invoiceNumber}, Pelanggan: {$customerName}): Pesanan telah disetujui. Segera berikan akses untuk pembayaran agar proses dapat dilanjutkan.";
                                    break;
                                case Order::STATUS_CONFIRMED:
                                    $orderNotifications[$order->id] = "Pesanan #{$order->id} (Invoice: {$invoiceNumber}, Pelanggan: {$customerName}): Pesanan telah dikonfirmasi. Silakan segera lakukan proses pengemasan.";
                                    break;
                                case Order::STATUS_PROCESSING:
                                    $orderNotifications[$order->id] = "Pesanan #{$order->id} (Invoice: {$invoiceNumber}, Pelanggan: {$customerName}): Pesanan sedang dalam proses pengemasan. Harap selesaikan pengemasan secepatnya agar dapat segera dikirimkan.";
                                    break;
                            }
                        }
                        
                    
                        // Collect notifications for payments
                        $paymentNotifications = [];
                        foreach ($payments as $payment) {
                            if ($payment->status === Payment::STATUS_PENDING) {
                                $paymentNotifications[] = "Pembayaran untuk pesanan #{$payment->order->id}: Pelanggan telah melakukan pembayaran. Harap segera periksa bukti pembayaran untuk memastikan keabsahannya.";
                            }
                        }
                    
            return view('admin.dashboard.dashboard', compact('payments', 'orders', 'parameter', 'missingBankDetails', 'missingDetailsMessage', 'orderNotifications', 'paymentNotifications'));
        }

    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function faq()
    {
        $faqs = Faq::all();
        return view('customer.faq.index',compact('faqs'));
    }


    public function bigsale($slug)
    {
        $bigSales = BigSale::where('slug', $slug)
            ->where('status', true)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->first();

        if (!$bigSales) {
            abort(404, 'Big Sale not found or inactive.');
        }

        $productsQuery = $bigSales->products()->with('images');

        // Filter berdasarkan kategori
        if (request()->has('category') && request()->category) {
            $productsQuery->where('category_id', request()->category);
        }

        // Sorting
        if (request()->has('sort')) {
            switch (request()->get('sort')) {
                case 'terbaru':
                    $productsQuery->orderBy('created_at', 'desc');
                    break;
                case 'terlama':
                    $productsQuery->orderBy('created_at', 'asc');
                    break;
                }
            }

        $products = $productsQuery->get();

        // Filter message
        $filterMessage = [];
        if (request()->has('category') && request()->category) {
            $filterMessage[] = 'Category: ' . Category::find(request()->category)->name;
        }

        $categories = Category::all();

        return view('customer.bigsale.index', compact('bigSales', 'products', 'categories', 'filterMessage'));
    }




    

}

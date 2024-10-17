@extends('layouts.customer.master')

@section('content')


    <!-- Single Page Header start -->
<div class="container-fluid page-header py-5"
style="position: relative; overflow: hidden; background: url('{{ asset('storage/img/cart-header-bg.jpg') }}') no-repeat center center; background-size: cover;">
<div style="background: rgba(0, 0, 0, 0.096); position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1;">
</div>
<h1 class="text-center display-6 text-dark" style="position: relative; z-index: 2;">{{ $product->name }}</h1>
<ol class="breadcrumb justify-content-center mb-0" style="position: relative; z-index: 2;">
    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark">Beranda</a></li>
    <li class="breadcrumb-item"><a href="{{ route('shop') }}" class="text-dark">Shop</a></li>
    <li class="breadcrumb-item active text-primary">{{ $product->name }}</li>
</ol>
</div>
<!-- Single Page Header End -->


<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row g-4 mb-5">
            <div class="col-lg-8 col-xl-9">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="rounded">
                            @if($product->images->count() > 1)
                                <!-- Bootstrap Carousel for multiple images -->
                                <div id="productCarousel{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($product->images as $key => $image)
                                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                <img src="{{ asset($image->image) }}" 
                                                     class="d-block w-100 rounded media-content zoomable-image" 
                                                     alt="{{ $product->name }}" style="max-height: 400px;">
                                            </div>
                                        @endforeach
                    
                                        @if($product->videos->isNotEmpty())
                                            <div class="carousel-item">
                                                <video class="d-block w-100 rounded media-content" controls>
                                                    <source src="{{ asset($product->videos->first()->video) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        @endif
                                    </div>
                    
                                    <!-- Carousel Controls -->
                                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel{{ $product->id }}" data-bs-slide="prev" style="background-color: white; border-radius: 50%; width: 40px; height: 40px;">
                                        <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: invert(0);"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel{{ $product->id }}" data-bs-slide="next" style="background-color: white; border-radius: 50%; width: 40px; height: 40px;">
                                        <span class="carousel-control-next-icon" aria-hidden="true" style="filter: invert(0);"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            @elseif($product->images->isNotEmpty())
                                <!-- Single image if only one exists -->
                                <img src="{{ asset($product->images->first()->image) }}" class="d-block w-100 rounded" style="max-height: 400px;" alt="{{ $product->name }}">
                            @else
                                <!-- Fallback image if no images exist -->
                                <img src="https://gsacommerce.com/assets/frontend/image/gsa-logo.svg" class="img-fluid rounded" alt="No Image">
                            @endif
                            
                            <!-- CSS Styles to Ensure Consistent Media Size -->
                            <style>
                                .media-content {
                                    height: 400px; /* Set a fixed height for consistency */
                                    width: 100%;
                                    object-fit: cover; /* Ensures the content fills the area without distortion */
                                    object-position: center; /* Centers the content */
                                    cursor: pointer; /* Change cursor to pointer on hover */
                                }
                                .zoomable-image {
                                    transform: scale(1); /* Default scale */
                                    transition: transform 0.2s, transform-origin 0.2s;
                                }
                            </style>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        
                        <div style=" #ddd; border-radius: 8px; padding: 16px; width: 100%; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);" class="mb-2">
                            <h1 style="line-height: 1.2; color: #333; margin-bottom: 5px;">{{ $product->name }}</h1>
                            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                @php
                                    // Average rating calculation
                                    $averageRating = $product->reviews->avg('rating') ?? 0;

                                    // Total quantity sold calculation
                                    $totalSold = DB::table('t_ord_items')
                                        ->join('t_orders', 't_ord_items.order_id', '=', 't_orders.id')
                                        ->where('t_ord_items.product_id', $product->id)
                                        ->where('t_orders.status', 'completed')
                                        ->sum('t_ord_items.quantity');

                                    // Count of reviews
                                    $reviewCount = $product->reviews->count(); // Get the count of reviews
                                @endphp

                                <div style="display: flex; align-items: center; font-family: Arial, sans-serif;">
                                    <p style="font-size: 14px; color: #666; margin-bottom: 0; margin-right: 10px;">
                                        <i class="fa fa-shopping-bag" style="color: #28a745; margin-right: 4px;"></i>Terjual {{ $totalSold }}
                                    </p>
                                    
                                    <span style="font-size: 20px; color: #666; margin: 0 10px;">.</span> <!-- Larger dot separator -->
                                    
                                    <i class="fa fa-star" style="font-size: 20px; color: #ffc107;"></i>
                                    <span style="font-size: 14px; color: #666; margin-left: 4px;">
                                        {{ number_format($averageRating, 1) }} / 5 ({{ $reviewCount }} {{ __('review') }})
                                    </span>
                                    
                                    <span style="font-size: 20px; color: #666; margin: 0 10px;">.</span> <!-- Larger dot separator -->
                                    
                                    <p class="text-muted" style="font-size: 14px; color: #666; margin: 0; display: flex; align-items: center;">
                                        <i class="fa fa-check-circle" style="color: #28a745; margin-right: 4px;"></i>{{ __("Bekasi") }}
                                    </p>
                                </div>
                            </div>
                            <p style="font-size: 14px; color: #666; margin-bottom: 5px;">Category: {{ $product->category->name }}</p>
                        </div>

                        <p class="mb-4 mt-2">{{ $product->description }}</p>
                        @if($product->stock > 0)
                        <div class="d-flex align-items-center">
                            <!-- Quantity Input Group -->
                            <div class="input-group quantity me-3" style="width: 130px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm text-center border-0" id="quantity" value="1">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        
                            <!-- Add to Cart Button -->
                            <a href="#" id="add-to-cart" class="btn border border-secondary rounded-pill px-4 py-2 text-primary">
                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                            </a>
                            <a href="#" id="add-to-wishlist" class="btn border border-secondary rounded-pill px-4 py-2 text-primary mx-1" data-product-id="{{ $product->id }}">
                                <i class="fa fa-heart text-primary"></i>
                            </a>
                        </div>
                        @else
                            <!-- Notifikasi bahwa stok habis -->
                            <div class="alert alert-danger mt-3" role="alert">
                                <i class="fa fa-exclamation-circle me-2"></i> This product is out of stock.
                            </div>
                        @endif
                        
                        <!-- Notifikasi untuk Keranjang -->
                        <div id="cart-message" class="cart-notification d-none" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(30, 30, 30, 0.9); color: white; padding: 20px 30px; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5); z-index: 1000; font-size: 18px;">
                            <div class="notification-content" style="display: flex; align-items: center; width: 100%;">
                                <span class="notification-icon" style="font-size: 30px; margin-right: 15px;">🎉</span>
                                <span class="notification-text" style="flex-grow: 1; font-weight: bold;">Product added to cart successfully!</span>
                                <button onclick="this.parentElement.parentElement.style.display='none'" style="background: transparent; border: none; color: white; cursor: pointer; font-size: 22px; margin-left: 15px;">&times;</button>
                            </div>
                        </div>

                        <!-- Notification Message -->
                        <div id="wishlist-message" class="wishlist-notification d-none" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(30, 30, 30, 0.9); color: white; padding: 20px 30px; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5); z-index: 1000; font-size: 18px;">
                            <div class="notification-content" style="display: flex; align-items: center; width: 100%;">
                                <span class="notification-icon" style="font-size: 30px; margin-right: 15px;">🎉</span>
                                <span class="notification-text" style="flex-grow: 1; font-weight: bold;">Product added to wishlist successfully!</span>
                                <button onclick="this.parentElement.parentElement.style.display='none'" style="background: transparent; border: none; color: white; cursor: pointer; font-size: 22px; margin-left: 15px;">&times;</button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-12">
                        <nav>
                            <div class="nav nav-tabs mb-3">
                                <button class="nav-link active border-white border-bottom-0 custom-tab" type="button" role="tab"
                                    id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                    aria-controls="nav-about" aria-selected="true">Specification</button>
                                <button class="nav-link border-white border-bottom-0 custom-tab" type="button" role="tab"
                                    id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                    aria-controls="nav-mission" aria-selected="false">Reviews</button>
                            </div>
                        </nav>
                        
                        <style>
                            .custom-tab {
                                background-color: black;
                                color: black !important;
                                border-color: transparent;
                            }
                        
                            /* Active tab */
                            .custom-tab.active {
                                background-color: black;
                                color: black !important;
                                border-color: transparent;
                            }
                        
                            /* Hover effect */
                            .custom-tab:hover {
                                background-color: #333;
                                color: black !important;
                            }
                        </style>
                        
                        <div class="tab-content mb-5">
                            <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                <p>{!! $product->specification !!}</p>
                            </div>
                            <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                                <!-- Display reviews -->
                                <h4 class="mb-4 fw-bold">Customer Reviews</h4>
                                <div id="reviews-container">
                                    @if($reviews->isEmpty())
                                        <p>No reviews yet. Be the first to leave a review!</p>
                                    @else
                                        @foreach($reviews as $review)
                                            <div class="review-item d-flex mb-4" id="review-{{ $review->id }}">
                                                <img src="{{ asset($review->user->profile_photo) }}" class="img-fluid rounded-circle p-3" 
                                                     style="width: 100px; height: 100px; object-fit: cover;" alt="User avatar">
                                                <div class="ms-3">
                                                    <p class="mb-1" style="font-size: 14px; color: #6c757d;">{{ $review->created_at->format('F d, Y') }}</p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h5 class="mb-0">{{ $review->user->name }}</h5>
                                                        <div class="d-flex align-items-center star-rating ms-2" style="font-size: 0;" data-rating="{{ $review->rating }}">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="fa fa-star" style="font-size: 20px; color: {{ $i <= $review->rating ? '#ffc107' : '#ccc' }};"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <p class="mt-2">{{ $review->comment }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            
                                <!-- Display the review form only if the user has completed an order -->
                                @foreach ($orders as $order)
                                @if (!in_array($order->id, $reviewedOrderIds))
                                    <form id="review-form-{{ $order->id }}" action="{{ route('reviews.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <h4 class="mb-5 fw-bold">Leave a Reply for Order #{{ $order->id }}</h4>
                                        <div class="review-messages mb-3"></div> <!-- Message container for each form -->
                                        <div class="row g-4">
                                            <div class="col-lg-12">
                                                <div class="border-bottom rounded my-4">
                                                    <textarea name="comment" class="form-control border-0" cols="30" rows="8" placeholder="Your Review *" spellcheck="false" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-between py-3 mb-5">
                                                    <div class="d-flex align-items-center">
                                                        <p class="mb-0 me-3">Please rate:</p>
                                                        <div class="d-flex align-items-center" style="font-size: 12px;">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}-{{ $order->id }}" required>
                                                                <label for="star{{ $i }}-{{ $order->id }}" style="font-size: 20px; cursor: pointer;">
                                                                    <i class="fa fa-star"></i>
                                                                </label>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn border border-secondary text-primary rounded-pill px-4 py-3">Post Comment</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <p>You have already reviewed the product for Order #{{ $order->id }}.</p>
                                @endif
                                @endforeach
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="row g-4 fruite">
                    <div class="col-lg-12">
                        <div class="mb-4">
                            <h4>Categories</h4>
                            <ul class="list-unstyled fruite-categorie">
                                @foreach($categories as $category)
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <!-- Display category-specific icon or a default icon if none is available -->
                                            <a href="{{ route('shop', ['category_id' => $category->id]) }}">
                                                <i class="{{ $category->icon ? $category->icon : 'fas fa-box' }} me-2"></i>{{ $category->name }}
                                            </a>
                                            <span>({{ $category->products->count() }})</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                    </div>
                    
                    <div class="col-lg-12">
                        <h4 class="mb-4">Featured Products</h4>
                        @foreach($randomProducts as $product)
                            <a href="{{ route('customer.product.show', $product->slug) }}" class="text-decoration-none" style="color: inherit; cursor: pointer;">
                                <div class="d-flex align-items-center justify-content-start mb-3">
                                    <div class="rounded me-4" style="width: 100px; height: 100px;">
                                        <img style="height: 80px;" src="{{ $product->images->isNotEmpty() ? asset($product->images->first()->image) : asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid rounded" alt="{{ $product->name }}">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">{{ $product->name }}</h6>
                                        @php
                                            // Calculate the average rating for the product
                                            $averageRating = $product->reviews->avg('rating');
                                            // Calculate full, half, and empty stars
                                            $fullStars = floor($averageRating);
                                            $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;
                                            $emptyStars = 5 - $fullStars - $halfStar;
                                        @endphp
                                        <div class="d-flex align-items-center mb-2">
                                            {{-- Display full stars --}}
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fa fa-star text-warning" style="font-size: 16px;"></i>
                                            @endfor
                    
                                            {{-- Display half star if applicable --}}
                                            @if ($halfStar)
                                                <i class="fa fa-star-half-alt text-warning" style="font-size: 16px;"></i>
                                            @endif
                    
                                            {{-- Display empty stars --}}
                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                <i class="fa fa-star" style="font-size: 16px; color: #ccc;"></i>
                                            @endfor
                    
                                            {{-- Display the numeric average rating --}}
                                            <span class="ms-2" style="font-size: 14px; color: #333;">
                                                {{ number_format($averageRating, 1) }} / 5
                                            </span>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <h5 class="fw-bold me-2">Rp{{ number_format($product->discount_price ?? $product->price, 0, ',', '.') }}</h5>
                                            @if($product->discount_price)
                                                <h5 class="text-danger text-decoration-line-through">Rp{{ number_format($product->price, 0, ',', '.') }}</h5>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="col-lg-12">
                        <div class="position-relative">
                            @php
                                // Fetch the active micro banner for the show_product page
                                $microBanner = \App\Models\BannerMicro::where('page', 'show_product')->where('active', true)->first();
                            @endphp
                            
                            <a href="{{ $microBanner ? $microBanner->link : '#' }}" target="_blank">
                                <img src="{{ $microBanner ? asset($microBanner->image) : asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded" alt="">
                            </a>
                    
                            <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                                <!-- Additional content can be placed here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="fw-bold mb-0">Related products</h1>
        <div class="container">
            <div class="vesitable">
                @if($relatedProducts->isNotEmpty())
                <div class="owl-carousel vegetable-carousel justify-content-center">
                    @foreach($relatedProducts as $relatedProduct)
                        <a href="{{ route('customer.product.show', $relatedProduct->slug) }}" class="text-decoration-none" style="color: inherit;">
                            <div class="rounded position-relative fruite-item shadow-sm" style="transition: transform 0.3s ease, box-shadow 0.3s ease; overflow: hidden; cursor: pointer;">
                                <!-- Product Image -->
                                <div class="fruite-img overflow-hidden">
                                    <img src="{{ $relatedProduct->images->isNotEmpty() ? asset($relatedProduct->images->first()->image) : 'https://gsacommerce.com/assets/frontend/image/gsa-logo.svg' }}" 
                                         class="img-fluid w-100 rounded-top" 
                                         alt="{{ $relatedProduct->name }}" 
                                         style="transition: transform 0.3s ease; height: 250px; object-fit: {{ $relatedProduct->images->isNotEmpty() ? 'cover' : 'contain' }};">
                                </div>
        
                                <!-- Pre-Order Badge -->
                                @if($relatedProduct->is_pre_order)
                                <div class="text-white bg-primary px-2 py-1 rounded position-absolute" style="top: 10px; left: 10px; font-size: 12px;">Pre Order</div>
                                @endif
        
                                <!-- Product Details -->
                                <div class="p-2">
                                    <!-- Product Name -->
                                    <p class="text-dark fw-bold text-start mb-1" style="
                                        font-size: 16px; 
                                        overflow: hidden; 
                                        display: -webkit-box; 
                                        -webkit-line-clamp: 2; 
                                        -webkit-box-orient: vertical; 
                                        text-overflow: ellipsis;
                                        font-weight: normal;
                                    ">
                                        {{ $relatedProduct->name }}
                                    </p>
        
                                    <!-- Price Section -->
                                    @if($relatedProduct->discount_price)
                                    <p class="text-dark text-start fs-6 mb-2">
                                        <span class="text-decoration-line-through text-muted">Rp{{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                                        <span class="text-danger fw-bold" style="font-size: 12px;">
                                            {{ round((($relatedProduct->price - $relatedProduct->discount_price) / $relatedProduct->price) * 100) }}% off
                                        </span> <br>
                                        <span class="text-danger fw-bold mb-2">Rp{{ number_format($relatedProduct->discount_price, 0, ',', '.') }}</span>
                                    </p>
                                    @else
                                    <p class="text-dark text-start fs-6 mb-2">Rp{{ number_format($relatedProduct->price, 0, ',', '.') }}</p>
                                    <p class="text-muted text-start fs-6 mb-2 small"><i class="fa fa-check-circle text-success me-1"></i>{{ __("Bekasi") }}</p>
                                    @endif
        
                                    <!-- Rating Information -->
                                    <div class="d-flex justify-content-start align-items-center mb-2">
                                        @php
                                            // Calculate the average rating for the product
                                            $averageRating = $relatedProduct->reviews->avg('rating') ?? 0;
        
                                            // Calculate the total quantity sold
                                            $totalSold = DB::table('t_ord_items')
                                            ->join('t_orders', 't_ord_items.order_id', '=', 't_orders.id')
                                            ->where('t_ord_items.product_id', $relatedProduct->id)
                                            ->where('t_orders.status', 'completed')
                                            ->sum('t_ord_items.quantity');        
                                            
                                            // Get the current stock quantity
                                            $stockQuantity = $relatedProduct->stock ?? 0;
                                        @endphp
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-star text-warning" style="font-size: 14px;"></i>
                                            <span class="ms-2" style="font-size: 12px; color: #333;">
                                                {{ number_format($averageRating, 1) }} / 5
                                            </span>
                                        </div>
                                        <span class="mx-2">|</span>
                                        <span class="text-muted small">{{ $totalSold }} terjual</span>
                                    </div>
        
                                    <!-- Stock and Quantity Information -->

                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                @else
                <div class="text-center py-5">
                    <p class="text-muted" style="font-size: 18px;">Belum Tersedia, Mohon Di Tunggu Secara Berkala</p>
                </div>
                @endif
            </div>
            <!-- Updated Button -->
            <div class="text-center mt-4">
                <a href="{{ route('shop') }}" class="btn btn-primary px-5 py-2 rounded-pill text-white" style="font-size: 16px;">Lainnya</a>
            </div>
        </div>
        
        
        
        
        
    </div>
</div>




<script>
    document.getElementById('add-to-wishlist').addEventListener('click', function (e) {
        e.preventDefault(); // Prevent the default behavior of the link

        var productId = this.getAttribute('data-product-id');

        // Make the AJAX request
        fetch('{{ route("wishlist.add") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show the notification
                var notification = document.getElementById('wishlist-message');
                notification.querySelector('.notification-text').textContent = 'Product added to wishlist successfully!';
                notification.classList.remove('d-none');
                
                // Hide the notification after 3 seconds
                setTimeout(function () {
                    notification.classList.add('d-none');
                }, 3000);
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>


<script>
        document.querySelectorAll('[id^="review-form"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission behavior

            const formData = new FormData(form);
            const url = form.getAttribute('action');
            const messageContainer = form.querySelector('.review-messages');

            // Clear any previous messages
            messageContainer.innerHTML = '';

            // Send the AJAX request using fetch
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                // If the response is not okay, throw an error
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }
                return response.json(); // Parse JSON from the response
            })
            .then(data => {
                if (data.success) {
                    // Display success message
                    messageContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    const reviewContainer = document.getElementById('reviews-container');

                    // Append the new review dynamically
                    const newReview = document.createElement('div');
                    newReview.classList.add('review-item', 'd-flex', 'mb-4');
                    newReview.innerHTML = `
                        <img src="${data.review.profile_photo}" class="img-fluid rounded-circle p-3" 
                            style="width: 100px; height: 100px; object-fit: cover;" alt="User avatar">
                        <div class="ms-3">
                            <p class="mb-1" style="font-size: 14px; color: #6c757d;">${data.review.created_at}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">${data.review.name}</h5>
                                <div class="d-flex align-items-center star-rating ms-2" style="font-size: 0;">
                                    ${generateStars(data.review.rating)}
                                </div>
                            </div>
                            <p class="mt-2">${data.review.comment}</p>
                        </div>
                    `;

                    reviewContainer.prepend(newReview); // Add the new review at the top
                    form.reset(); // Clear the form fields

                    // Hide the form as it has been submitted
                    form.style.display = 'none';
                } else if (data.errors) {
                    // Display validation errors
                    let errorsHtml = '<div class="alert alert-danger"><ul>';
                    for (const error of data.errors) {
                        errorsHtml += `<li>${error}</li>`;
                    }
                    errorsHtml += '</ul></div>';
                    messageContainer.innerHTML = errorsHtml;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageContainer.innerHTML = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
            });
        });
    });

    // Helper function to generate stars
    function generateStars(rating) {
        let starsHtml = '';
        for (let i = 1; i <= 5; i++) {
            starsHtml += `<i class="fa fa-star" style="font-size: 20px; color: ${i <= rating ? '#ffc107' : '#ccc'};"></i>`;
        }
        return starsHtml;
    }

</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    var zoomableImages = document.querySelectorAll('.zoomable-image');

    zoomableImages.forEach(function (img) {
        img.addEventListener('mousemove', function (e) {
            var rect = img.getBoundingClientRect();
            var x = e.clientX - rect.left;
            var y = e.clientY - rect.top;

            img.style.transformOrigin = `${(x / rect.width) * 100}% ${(y / rect.height) * 100}%`;
            img.style.transform = 'scale(1.5)';
        });

        img.addEventListener('mouseleave', function () {
            img.style.transform = 'scale(1)';
            img.style.transformOrigin = 'center center';
        });
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Clone nodes to prevent multiple event listeners
        var minusBtn = document.querySelector('.btn-minus');
        var plusBtn = document.querySelector('.btn-plus');

        minusBtn.replaceWith(minusBtn.cloneNode(true)); // Clone the minus button
        plusBtn.replaceWith(plusBtn.cloneNode(true));   // Clone the plus button

        // Get the cloned buttons (now without any previous event listeners)
        var newMinusBtn = document.querySelector('.btn-minus');
        var newPlusBtn = document.querySelector('.btn-plus');

        // Attach event listeners to new cloned buttons
        newMinusBtn.addEventListener('click', function () {
            var input = document.getElementById('quantity');
            var quantity = parseInt(input.value);
            if (quantity > 1) {
                input.value = quantity - 1;
            }
        });

        newPlusBtn.addEventListener('click', function () {
            var input = document.getElementById('quantity');
            var quantity = parseInt(input.value);
            input.value = quantity + 1;
        });

        // Add to cart functionality with AJAX
        document.getElementById('add-to-cart').addEventListener('click', function (e) {
            e.preventDefault();

            var productId = {{ $product->id }}; // Replace with actual product ID from backend
            var quantity = document.getElementById('quantity').value;

            // Send AJAX request
            fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cart-message').classList.remove('d-none');
                    setTimeout(() => {
                        document.getElementById('cart-message').classList.add('d-none');
                    }, 3000);
                } else if (data.error) {
                    alert(data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>


@endsection
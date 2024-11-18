@extends('layouts.customer.master')

@section('content')

<!-- Carousel -->
<div id="heroCarousel" class="carousel slide position-relative mt-1" data-bs-ride="carousel">
    <div class="carousel-inner">
        @if($banners->isNotEmpty())
            @foreach($banners as $index => $banner)
                <a href="{{ $banner->link }}" class="carousel-item {{ $index === 0 ? 'active' : '' }}" style="cursor: pointer;">
                    <div class="container-fluid py-5 hero-header" style="background: linear-gradient(rgba(248, 223, 173, 0.1), rgba(248, 223, 173, 0.1)), url('{{ asset($banner->image) }}'); background-position: center center; background-repeat: no-repeat; background-size: cover;">
                        <div class="container py-5">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <h4 class="mb-3 text-light">{{ $banner->title }}</h4>
                                    <h1 class="mb-5 display-3 text-light">{{ $banner->description }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        @else
            {{-- Fallback content when there are no banners --}}
            <a href="{{ route('shop') }}" class="carousel-item active" style="cursor: pointer;">
                <div class="container-fluid py-5 hero-header" style="background: linear-gradient(rgba(248, 223, 173, 0.1), rgba(248, 223, 173, 0.1)), url('{{ asset('assets/default/image/carousel_default.jpg') }}'); background-position: center center; background-repeat: no-repeat; background-size: cover;">
                    <div class="container py-5">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <h4 class="mb-3 text-light">{{ __('banner.fallback_title') }}</h4>
                                <h1 class="mb-5 display-3 text-light">{{ __('banner.fallback_description') }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endif
    </div>

    <!-- Previous Button -->
    <button class="carousel-control-prev prevs" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">{{ __('banner.default_button_prev') }}</span>
    </button>

    <!-- Next Button -->
    <button class="carousel-control-next nexts" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">{{ __('banner.default_button_next') }}</span>
    </button>
</div>



@if($approvedOrders->count() > 0)
    @foreach($approvedOrders as $order)
        @php
            // Calculate the time left for payment (48 hours)
            $approvedTime = $order->approved_at; // The timestamp when the order was approved
            $timeLimit = 48 * 60 * 60; // 48 hours in seconds
            $currentTime = now(); // Current timestamp
            $elapsedTime = $currentTime->diffInSeconds($approvedTime); // Time elapsed since approved
            $remainingTime = max(0, $timeLimit - $elapsedTime); // Calculate remaining time
            $hours = floor($remainingTime / 3600); // Calculate hours only
        @endphp
        <div id="order-notification-{{ $order->id }}" class="gsac-alert gsac-alert-warning alert-dismissible fade show mb-3 mt-4" role="alert">
            <div class="gsac-alert-content d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <div class="notification-text mb-2 mb-md-0">
                    <i class="fas fa-info-circle me-2 gsac-alert-icon"></i>
                    <strong>Order ID {{ $order->id }}</strong>, telah disetujui. Mohon segera selesaikan pembayaran 
                    "<strong>{{ $hours }} jam</strong>" sebelum tenggat waktunya.
                </div>
                <a href="{{ route('customer.order.show', ['orderId' => $order->id]) }}" class="gsac-btn gsac-btn-warning btn-block btn-md-auto">
                    Lihat & Bayar
                </a>
            </div>
            <button type="button" class="gsac-btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endforeach
@endif


    @if(session('info'))
    <div id="floating-notification-info" class="alert alert-danger alert-dismissible fade show position-fixed d-flex align-items-center" role="alert" style="bottom: 20px; right: 20px; z-index: 1050; min-width: 320px; max-width: 420px; padding: 20px;">
        <i class="fas fa-exclamation-circle me-3" style="font-size: 24px;"></i>
        <span>{{ session('info') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('welcome'))
    <div id="floating-notification-welcome" class="alert alert-success alert-dismissible fade show position-fixed d-flex align-items-center" role="alert" style="bottom: 20px; right: 20px; z-index: 1050; min-width: 320px; max-width: 420px; padding: 20px;">
        <i class="fas fa-check-circle me-3" style="font-size: 24px;"></i>
        <span>{{ session('welcome') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('welcome_back'))
    <div id="floating-notification-welcome-back" class="alert alert-info alert-dismissible fade show position-fixed d-flex align-items-center" role="alert" style="bottom: 20px; right: 20px; z-index: 1050; min-width: 320px; max-width: 420px; padding: 20px;">
        <i class="fas fa-smile me-3" style="font-size: 24px;"></i>
        <span>{{ session('welcome_back') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Cek apakah notifikasi ada
        var notification = document.getElementById('floating-notification');
        if (notification) {
            // Setelah 2 detik, sembunyikan notifikasi
            setTimeout(function() {
                notification.classList.remove('show');
                notification.classList.add('fade');
                // Hapus notifikasi dari DOM setelah animasi selesai
                setTimeout(function() {
                    notification.remove();
                }, 150); // Waktu untuk fade-out
            }, 5000); // Waktu tampil 2 detik
        }
    });
</script>

    <section class="hero mt-5">
        <div class="container-fluid">
                    @if($bigSales && $bigSales->products->isNotEmpty())
                        <section class="exclusive-deal-area">
                            <div class="container-fluid">
                                <div class="row justify-content-center align-items-center rounded"
                                    style="background: url('{{ asset($bigSales->banner) }}') no-repeat center center/cover; position: relative; border-radius: 10px;">
                                    <!-- Transparent overlay -->
                                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); border-radius: 10px;">
                                    </div>
                                    <div class="col-lg-6 no-padding exclusive-left" style="position: relative; z-index: 1;">
                                        <div class="row clock_sec clockdiv" id="clockdiv">
                                            <div class="col-lg-12 text-center">
                                                <br><br>
                                                <h2 style="color: #ffffff; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">{{ $bigSales->title }}</h2>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 text-center">
                                                <div class="row clock-wrap" style="gap: 10px">
                                                    <!-- Countdown section with smooth animation and rounded styles -->
                                                    <div class="col clockinner1 clockinner" style="border-radius: 20px; background-color: rgba(255, 255, 255, 0.9); padding: 10px; animation: pulse 1s infinite;">
                                                        <h1 id="days" class="days" style="color: black;">00</h1>
                                                        <span class="smalltext" style="color: black;">{{ __('messages.days') }}</span>
                                                    </div>
                                                    <div class="col clockinner clockinner1" style="border-radius: 20px; background-color: rgba(255, 255, 255, 0.9); padding: 10px; animation: pulse 1s infinite;">
                                                        <h1 id="hours" class="hours" style="color: black;">00</h1>
                                                        <span class="smalltext" style="color: black;">{{ __('messages.hours') }}</span>
                                                    </div>
                                                    <div class="col clockinner clockinner1" style="border-radius: 20px; background-color: rgba(255, 255, 255, 0.9); padding: 10px; animation: pulse 1s infinite;">
                                                        <h1 id="minutes" class="minutes" style="color: black;">00</h1>
                                                        <span class="smalltext" style="color: black;">{{ __('messages.minutes') }}</span>
                                                    </div>
                                                    <div class="col clockinner clockinner1" style="border-radius: 20px; background-color: rgba(255, 255, 255, 0.9); padding: 10px; animation: pulse 1s infinite;">
                                                        <h1 id="seconds" class="seconds" style="color: black;">00</h1>
                                                        <span class="smalltext" style="color: black;">{{ __('messages.seconds') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br>
                                        <!-- Enhanced button with hover effect -->
                                        <a href="{{ route('customer.bigsale.index', ['slug' => $bigSales->slug ?? 'default-slug']) }}" class="primary-btn text-center"
                                        style="color: black; background-color: rgba(255, 255, 255, 0.9); padding: 10px 20px; border-radius: 5px; display: block; width: fit-content; margin: 0 auto; transition: background-color 0.3s ease;">
                                            {{ __('messages.shop_now') }}
                                        </a>
                                        <br><br>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <script>
                            const bigSaleEndTime = new Date("{{ date('Y-m-d\TH:i:s', strtotime($bigSales->end_time)) }}").getTime();

                            function startCountdown(endTime) {
                                const countdownInterval = setInterval(function() {
                                    const now = new Date().getTime();
                                    const distance = endTime - now;

                                    if (distance < 0) {
                                        clearInterval(countdownInterval);
                                        document.getElementById("days").innerHTML = "00";
                                        document.getElementById("hours").innerHTML = "00";
                                        document.getElementById("minutes").innerHTML = "00";
                                        document.getElementById("seconds").innerHTML = "00";
                                    } else {
                                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                        document.getElementById("days").innerHTML = days < 10 ? "0" + days : days;
                                        document.getElementById("hours").innerHTML = hours < 10 ? "0" + hours : hours;
                                        document.getElementById("minutes").innerHTML = minutes < 10 ? "0" + minutes : minutes;
                                        document.getElementById("seconds").innerHTML = seconds < 10 ? "0" + seconds : seconds;
                                    }
                                }, 1000);
                            }

                            startCountdown(bigSaleEndTime);
                        </script>
                        <style>
                            /* Button hover effect */
                            .primary-btn:hover {
                                background-color: rgba(255, 255, 255, 1);
                            }

                            /* Smooth pulse animation for countdown */
                            @keyframes pulse {
                                0% { transform: scale(1); }
                                50% { transform: scale(1.05); }
                                100% { transform: scale(1); }
                            }
                        </style>
                    @endif
            </div>
    </section>

<!-- Home Shop Start-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <div class="tab-class text-center">
            <!-- Category Section -->
            <div class="row g-4">
                <div class="col-lg-12">
                    <ul class="nav nav-pills d-inline-flex text-center mb-5 justify-content-center">
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill active category-filter" data-slug="all" href="#">
                                <span class="text-dark text-ellipsis" style="width: 130px;">{{ __('shop.all_products') }}</span>
                            </a>
                        </li>
                        @foreach($categories as $category)
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill category-filter" data-slug="{{ $category->slug }}" href="#">
                                <span class="text-dark text-ellipsis" style="width: 130px;">{{ $category->name }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Product Section -->
            <div id="product-list" class="tab-content">
                <div class="row g-4">
                    @foreach($products as $product)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <a href="{{ $product->stock > 0 ? route('customer.product.show', $product->slug) : 'javascript:void(0);' }}" class="text-decoration-none" style="color: inherit; pointer-events: {{ $product->stock > 0 ? 'auto' : 'none' }};">
                            <div class="rounded position-relative fruite-item shadow-sm {{ $product->stock > 0 ? '' : 'out-of-stock' }}" 
                                 style="transition: transform 0.3s, box-shadow 0.3s; overflow: hidden; cursor: {{ $product->stock > 0 ? 'pointer' : 'not-allowed' }}; filter: {{ $product->stock > 0 ? 'none' : 'grayscale(100%) opacity(0.6)' }};">
                                
                                <!-- Product Image -->
                                <div class="fruite-img overflow-hidden">
                                    <img src="{{ $product->images->isNotEmpty() ? asset($product->images->first()->image) : 'https://gsacommerce.com/assets/frontend/image/gsa-logo.svg' }}" 
                                         class="img-fluid w-100 rounded-top" 
                                         alt="{{ $product->name }}" 
                                         style="transition: transform 0.3s; height: 250px; object-fit: {{ $product->images->isNotEmpty() ? 'cover' : 'contain' }};">
                                </div>
                
                                <!-- Pre-Order Badge -->
                                @if($product->is_pre_order)
                                <div class="text-white bg-primary px-2 py-1 rounded position-absolute" style="top: 10px; left: 10px; font-size: 12px;">{{ __('shop.pre_order') }}</div>
                                @endif
                
                                <!-- Out of Stock Badge -->
                                @if($product->stock <= 0)
                                <div class="text-white bg-danger px-2 py-1 rounded position-absolute" style="top: 10px; right: 10px; font-size: 12px;">{{ __('shop.out_of_stock') }}</div>
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
                                        {{ $product->name }}
                                    </p>
                
                                    <!-- Price Section -->
                                    @if($product->discount_price)
                                    <p class="text-dark text-start fs-6 mb-2">
                                        <span class="text-decoration-line-through text-muted">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-danger fw-bold" style="font-size: 12px;">
                                            {{ __('shop.discount', ['percentage' => round((($product->price - $product->discount_price) / $product->price) * 100)]) }}
                                        </span> <br>
                                        <span class="text-danger fw-bold mb-2">Rp{{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                    </p>
                                    @else
                                    <p class="text-dark text-start fs-6 mb-2">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="text-muted text-start fs-6 mb-2 small"><i class="fa fa-check-circle text-success me-1"></i>{{ __('shop.location') }}</p>
                                    @endif
                
                                    <!-- Rating and Purchase Info -->
                                    <div class="d-flex justify-content-start align-items-center">
                                        <span class="text-muted small" style="display: flex; align-items: center;">
                                            @php
                                                $averageRating = $product->reviews->avg('rating') ?? 0;
                                            @endphp
                                                <i class="fa fa-star" style="color: {{ $averageRating ? '#ffc107' : '#ccc' }};"></i>
                                            <span class="ms-1">{{ number_format($averageRating, 1) }}</span>
                                        </span>
                                        
                                        <span class="mx-2">|</span>
                                        <span class="text-muted small">{{ __('shop.sold', ['count' => $product->completed_order_count]) }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('shop') }}" class="btn btn-primary px-5 py-2 rounded-pill text-white" style="font-size: 16px;">{{ __('shop.more_button') }}</a>
                </div>
            </div>            
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('.category-filter').on('click', function(e) {
            e.preventDefault();

            // Remove active class from all category filters
            $('.category-filter').removeClass('active');

            // Add active class to the clicked category filter
            $(this).addClass('active');

            var slug = $(this).data('slug');

            $.ajax({
                url: '{{ route("category.filter.ajax") }}', // Ensure the route is correct for your project
                type: 'POST',
                data: {
                    slug: slug,
                    _token: '{{ csrf_token() }}'
                },
                success: function(products) {
                    var productHtml = '';
                        
                    if (products.length === 0) {
                        productHtml = '<p>No products found.</p>';
                    } else {
                        $.each(products, function(index, product) {
                            // Ensure stock is passed correctly and perform the stock check
                            var stockAvailable = product.stock > 0;

                            // Grayscale filter and pointer events if out of stock
                            var stockClass = stockAvailable ? '' : 'out-of-stock';
                            var pointerEvents = stockAvailable ? 'auto' : 'none';
                            var cursorStyle = stockAvailable ? 'pointer' : 'not-allowed';
                            var filterStyle = stockAvailable ? 'none' : 'grayscale(100%) opacity(0.6)';

                            // Get the average rating for the product
                            var averageRating = product.reviews && product.reviews.length > 0 
                                ? product.reviews.reduce((sum, review) => sum + review.rating, 0) / product.reviews.length 
                                : 0;

                            // Build product HTML
                            productHtml += `
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <a href="${stockAvailable ? product.url : 'javascript:void(0);'}" 
                                        class="text-decoration-none" 
                                        style="color: inherit; pointer-events: ${pointerEvents};">
                                        
                                        <div class="rounded position-relative fruite-item shadow-sm ${stockClass}" 
                                             style="transition: transform 0.3s, box-shadow 0.3s; overflow: hidden; 
                                                    cursor: ${cursorStyle}; filter: ${filterStyle};">
                                            
                                            <!-- Product Image -->
                                            <div class="fruite-img overflow-hidden">
                                                <img src="${product.image ? product.image : 'https://gsacommerce.com/assets/frontend/image/gsa-logo.svg'}" 
                                                     class="img-fluid w-100 rounded-top" 
                                                     alt="${product.name}" 
                                                     style="transition: transform 0.3s; height: 250px; object-fit: cover;">
                                            </div>

                                            <!-- Pre-Order Badge -->
                                            ${product.is_pre_order ? '<div class="text-white bg-primary px-2 py-1 rounded position-absolute" style="top: 10px; left: 10px; font-size: 12px;">Pre Order</div>' : ''}
                                            
                                            <!-- Out of Stock Badge -->
                                            ${stockAvailable ? '' : '<div class="text-white bg-danger px-2 py-1 rounded position-absolute" style="top: 10px; right: 10px; font-size: 12px;">Out of Stock</div>'}

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
                                                    ${product.name}
                                                </p>

                                                <!-- Price Section -->
                                                ${product.discount_price ? `
                                                <p class="text-dark text-start fs-6 mb-2">
                                                    <span class="text-decoration-line-through text-muted">Rp${parseInt(product.price).toLocaleString('id-ID')}</span>
                                                    <span class="text-danger fw-bold" style="font-size: 12px;">
                                                        ${Math.round(((product.price - product.discount_price) / product.price) * 100)}% off
                                                    </span> <br>
                                                    <span class="text-danger fw-bold mb-2">Rp${parseInt(product.discount_price).toLocaleString('id-ID')}</span>
                                                </p>` : `
                                                <p class="text-dark text-start fs-6 mb-2">Rp${parseInt(product.price).toLocaleString('id-ID')}</p>`}

                                                <p class="text-muted text-start fs-6 mb-2 small"><i class="fa fa-check-circle text-success me-1"></i>{{ __("Bekasi") }}</p>

                                                <!-- Rating and Purchase Info -->
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <span class="text-muted small">
                                                        <i class="fa fa-star text-warning me-1"></i>
                                        ${product.average_rating} <!-- Display average rating -->
                                                    </span>
                                                    <span class="mx-2">|</span>
                                                    <span class="text-muted small">${product.sales_count ? product.sales_count + '+ terjual' : '0 terjual'}</span>
                                                    <span class="mx-2">|</span>
                                                    <span class="text-muted small">${product.completed_order_count} terjual</span> 
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>`;
                        });
                    }

                    // Update the product list
                    $('#product-list .row').html(productHtml);
                }
            });
        });
    });
</script>
<!-- Fruits Shop End-->


<section class="hero-section-bigsale">
    <div class="container-bigsale">
        <div class="row-bigsale">
            <div class="col-bigsale">
                @if($bigSales && $bigSales->modal_image)
                <!-- Modal with Image -->
                <div class="modal fade" id="bigsaleModal" tabindex="-1" aria-labelledby="bigsaleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-bigsale">
                        <div class="modal-content modal-content-bigsale border-0">
                            <div class="modal-body modal-body-bigsale p-0 position-relative">
                                <!-- Link the image to the Big Sale page -->
                                <a href="{{ route('customer.bigsale.index', ['slug' => $bigSales->slug]) }}">
                                    <img src="{{ asset($bigSales->modal_image) }}" alt="Big Sale Banner" class="img-fluid img-bigsale">
                                </a>
                                <button type="button" class="btn-close btn-close-bigsale" data-bs-dismiss="modal" aria-label="Close">✕</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bootstrap 5 JS Modal activation script -->
                <script type="text/javascript">
                    document.addEventListener('DOMContentLoaded', function () {
                        var bigsaleModal = new bootstrap.Modal(document.getElementById('bigsaleModal'));
                        bigsaleModal.show();
                    });
                </script>
                @endif
            </div>
        </div>
    </div>
</section>


<style>
    /* Hero Section Custom Styling */
.hero-section-bigsale .container-bigsale {
    width: 100%;
    margin: 0 auto;
}

.hero-section-bigsale .row-bigsale {
    display: flex;
    justify-content: center;
    align-items: center;
}

.hero-section-bigsale .col-bigsale {
    position: relative;
}

/* Custom Modal Content Styling */
.modal-content-bigsale {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    background-color: transparent; /* Removes background */
}

.modal-body-bigsale {
    padding: 0;
}

/* Modal Image Styling */
.img-bigsale {
    width: 100%;
    height: auto; /* Maintain aspect ratio */
    object-fit: cover; /* Preserve proportions */
    border-radius: 10px; /* Rounded corners */
}

/* Close Button Styling */
.btn-close-bigsale {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 40px;
    height: 40px;
    background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent background */
    color: #fff; /* White icon color */
    border-radius: 50%;
    border: none;
    font-size: 1.6rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-close-bigsale:hover {
    background-color: rgba(255, 0, 0, 0.7); /* Red hover effect */
    color: #fff;
}

/* Modal Dialog Styling */
.modal-dialog-bigsale {
    max-width: 900px;
    margin: 0 auto;
}

</style>





<style>
    /* Base styling for notifications */
    #floating-notification-info,
    #floating-notification-welcome,
    #floating-notification-welcome-back {
        animation: fadeInSlide 0.7s ease-out;
        backdrop-filter: blur(10px);
        background: rgba(0, 0, 0, 0.85);
        border: 1px solid rgba(0, 0, 0, 0.5);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border-radius: 15px;
        color: #f1f1f1;
    }

    /* Smooth fade-in and slide animation */
    @keyframes fadeInSlide {
        0% {
            transform: translateY(40px);
            opacity: 0;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Elegant shadow and rounded corners */
    .alert {
        border: none;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
        border-radius: 15px;
        background-clip: padding-box;
    }

    /* Icon styling */
    .alert i {
        color: #f1f1f1;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    /* Button close styling */
    .btn-close {
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
    }

    .btn-close:hover {
        background-color: rgba(255, 255, 255, 0.5);
    }

    /* Adding a subtle glow effect */
    .alert:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.5);
        transition: box-shadow 0.3s ease;
    }

    /* Gradient effect for a darker luxurious feel */
    .alert.alert-danger {
        background: linear-gradient(135deg, rgba(139, 0, 0, 0.9), rgba(139, 0, 0, 0.7));
    }

    .alert.alert-success {
        background: linear-gradient(135deg, rgba(0, 100, 0, 0.9), rgba(0, 100, 0, 0.7));
    }

    .alert.alert-info {
        background: linear-gradient(135deg, rgba(0, 0, 139, 0.9), rgba(0, 0, 139, 0.7));
    }
</style>


<style>
    /* Base styling for GSAC notifications */
    .gsac-alert {
        padding: 15px;
        border-radius: 10px;
        background-color: #fff3cd;
        border-left: 5px solid #ffc107;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    /* Content styling */
    .gsac-alert-content {
        display: flex;
        align-items: center;
    }

    /* Icon styling for GSAC notifications */
    .gsac-alert-icon {
        font-size: 20px;
        color: #856404;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    /* Button close styling */
    .gsac-btn-close {
        background-color: transparent;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        opacity: 0.7;
    }

    .gsac-btn-close:hover {
        background-color: rgba(255, 193, 7, 0.1);
        opacity: 1;
    }

    /* Styling for the 'View & Pay' button */
    .gsac-btn {
        text-decoration: none;
        padding: 10px 15px;
        border-radius: 25px; /* Rounded corners */
        font-weight: bold;
        transition: background-color 0.3s, transform 0.2s;
        color: white; /* Text color */
        border: none; /* No border */
        background-color: #ffc107; /* Base background color */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    }

    .gsac-btn-warning {
        background-color: #ffc107; /* Warning button color */
    }

    .gsac-btn-warning:hover {
        background-color: #e0a800; /* Darker shade on hover */
        transform: scale(1.05); /* Slightly enlarge on hover for effect */
    }

    /* Responsive handling for alert box */
    @media (max-width: 768px) {
        .gsac-alert {
            min-width: 100%;
        }
    }
</style>

@endsection

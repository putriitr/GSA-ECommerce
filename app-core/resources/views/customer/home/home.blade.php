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
                                <h4 class="mb-3 text-light">Toko GSacommerce</h4>
                                <h1 class="mb-5 display-3 text-light">Your Professional Partner</h1>
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
        <span class="visually-hidden">Previous</span>
    </button>

    <!-- Next Button -->
    <button class="carousel-control-next nexts" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


@if(session('info'))
    <div id="floating-notification" class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 mt-5 me-3" role="alert" style="z-index: 1050;">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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


{{-- <a href="{{ route('shop') }}" class="carousel-item active" style="cursor: pointer;">
    <div class="container-fluid py-5 hero-header" style="background: linear-gradient(rgba(248, 223, 173, 0.1), rgba(248, 223, 173, 0.1)), url('{{ asset('assets/default/image/carousel_default.jpg') }}'); background-position: center center; background-repeat: no-repeat; background-size: cover;">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <h4 class="mb-3 text-light">Toko GSacommerce</h4>
                    <h1 class="mb-5 display-3 text-light">Your Professional Partner</h1>
                </div>
            </div>
        </div>
    </div>
</a> --}}

<!-- Fruits Shop Start-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <div class="tab-class text-center">
            <!-- Category Section -->
            <div class="row g-4">
                <div class="col-lg-12">
                    <ul class="nav nav-pills d-inline-flex text-center mb-5 justify-content-center">
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill active category-filter" data-slug="all" href="#">
                                <span class="text-dark text-ellipsis" style="width: 130px;">Semua Produk</span>
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
                                <div class="text-white bg-primary px-2 py-1 rounded position-absolute" style="top: 10px; left: 10px; font-size: 12px;">Pre Order</div>
                                @endif
                
                                <!-- Out of Stock Badge -->
                                @if($product->stock <= 0)
                                <div class="text-white bg-danger px-2 py-1 rounded position-absolute" style="top: 10px; right: 10px; font-size: 12px;">Out of Stock</div>
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
                                            {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% off
                                        </span> <br>
                                        <span class="text-danger fw-bold mb-2">Rp{{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                    </p>
                                    @else
                                    <p class="text-dark text-start fs-6 mb-2">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="text-muted text-start fs-6 mb-2 small"><i class="fa fa-check-circle text-success me-1"></i>{{ __("Bekasi") }}</p>
                                    @endif
                
                                    <!-- Rating and Purchase Info -->
                                    <div class="d-flex justify-content-start align-items-center">
                                        <span class="text-muted small" style="display: flex; align-items: center;">
                                            @php
                                                // Calculate the average rating for the product
                                                $averageRating = $product->reviews->avg('rating') ?? 0;
                                            @endphp
                                                <i class="fa fa-star" style="color: {{ $averageRating ? '#ffc107' : '#ccc' }};"></i>
                                            <span class="ms-1">{{ number_format($averageRating, 1) }}</span>
                                        </span>
                                        
                                        <span class="mx-2">|</span>
                                        <span class="text-muted small">{{ $product->completed_order_count }}+ terjual</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('shop') }}" class="btn btn-primary btn-sm">View All Products</a>
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


@endsection

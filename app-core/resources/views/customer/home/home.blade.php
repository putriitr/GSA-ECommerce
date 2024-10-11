@extends('layouts.customer.master')

@section('content')


<!-- Carousel -->
<div id="heroCarousel" class="carousel slide position-relative mt-1" data-bs-ride="carousel">
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
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
        </div>
    </div>

    <!-- Tombol Previous -->
    <button class="carousel-control-prev prevs" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>

    <!-- Tombol Next -->
    <button class="carousel-control-next nexts" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Fruits Shop Start-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <div class="tab-class text-center">
            <!-- Title Section -->
            <div class="row">
                <div class="col-lg-12">
                    <h3>Produk Kami</h3>
                </div>
            </div>

            <!-- Category Section -->
            <div class="row g-4 mt-3">
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
                        <a href="{{ route('customer.product.show', $product->slug) }}" class="text-decoration-none" style="color: inherit;">
                            <div class="rounded position-relative fruite-item shadow-sm" style="transition: transform 0.3s, box-shadow 0.3s; overflow: hidden; cursor: pointer;">
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
                                        <span class="text-muted small">
                                            <i class="fa fa-star text-warning me-1"></i>
                                            {{ $product->rating ?? '0.0' }}
                                        </span>
                                        <span class="mx-2">|</span>
                                        <span class="text-muted small">70+ terjual</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
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
            url: '{{ route("category.filter.ajax") }}', // Pastikan rute ini sesuai dengan proyekmu
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
                        var discountPercentage = '';
                        if (product.discount_price) {
                            discountPercentage = Math.round(((product.price - product.discount_price) / product.price) * 100) + '% off';
                        }
                        
                        productHtml += `
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <a href="${product.url}" class="text-decoration-none" style="color: inherit;">
                                    <div class="rounded position-relative fruite-item shadow-sm" style="transition: transform 0.3s, box-shadow 0.3s; overflow: hidden; cursor: pointer;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="${product.image ? product.image : 'https://gsacommerce.com/assets/frontend/image/gsa-logo.svg'}" 
                                                 class="img-fluid w-100 rounded-top" 
                                                 alt="${product.name}" 
                                                 style="transition: transform 0.3s; height: 250px; object-fit: cover;">
                                        </div>
                    
                                        ${product.is_pre_order ? '<div class="text-white bg-primary px-2 py-1 rounded position-absolute" style="top: 10px; left: 10px; font-size: 12px;">Pre Order</div>' : ''}
                    
                                        <div class="p-2">
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
                    
                                            ${product.discount_price ? `
                                            <p class="text-dark text-start fs-6 mb-2">
                                                <span class="text-decoration-line-through text-muted">Rp${parseInt(product.price).toLocaleString('id-ID')}</span>
                                                <span class="text-danger fw-bold" style="font-size: 12px;">
                                                    ${discountPercentage}
                                                </span> <br>
                                                <span class="text-danger fw-bold mb-2">Rp${parseInt(product.discount_price).toLocaleString('id-ID')}</span>
                                            </p>` : `
                                            <p class="text-dark text-start fs-6 mb-2">Rp${parseInt(product.price).toLocaleString('id-ID')}</p>`}
                                            <p class="text-muted text-start fs-6 mb-2 small"><i class="fa fa-check-circle text-success me-1"></i>{{ __("Bekasi") }}</p>

                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small">
                                                    <i class="fa fa-star text-warning me-1"></i>
                                                    ${product.rating ?? '0.0'}
                                                </span>
                                                <span class="mx-2">|</span>
                                                <span class="text-muted small">${product.sales_count ? product.sales_count + '+ terjual' : '0 terjual'}</span>
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

<!-- Bestsaler Product Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 700px;">
            <h1 class="display-4">Bestseller Products</h1>
            <p>Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-6 col-xl-4">
                <div class="p-4 bg-light">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100" alt="">
                        </div>
                        <div class="col-6">
                            <a href="#" class="h5">Organic Tomato</a>
                            <div class="d-flex my-3">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="mb-3">3.12 $</h4>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="p-4 rounded bg-light">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100" alt="">
                        </div>
                        <div class="col-6">
                            <a href="#" class="h5">Organic Tomato</a>
                            <div class="d-flex my-3">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="mb-3">3.12 $</h4>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="p-4 bg-light">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100" alt="">
                        </div>
                        <div class="col-6">
                            <a href="#" class="h5">Organic Tomato</a>
                            <div class="d-flex my-3">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="mb-3">3.12 $</h4>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="p-4 bg-light">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100" alt="">
                        </div>
                        <div class="col-6">
                            <a href="#" class="h5">Organic Tomato</a>
                            <div class="d-flex my-3">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="mb-3">3.12 $</h4>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="p-4 bg-light">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100" alt="">
                        </div>
                        <div class="col-6">
                            <a href="#" class="h5">Organic Tomato</a>
                            <div class="d-flex my-3">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="mb-3">3.12 $</h4>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="p-4 bg-light">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100" alt="">
                        </div>
                        <div class="col-6">
                            <a href="#" class="h5">Organic Tomato</a>
                            <div class="d-flex my-3">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="mb-3">3.12 $</h4>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="text-center">
                    <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid rounded" alt="">
                    <div class="py-4">
                        <a href="#" class="h5">Organic Tomato</a>
                        <div class="d-flex my-3 justify-content-center">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="mb-3">3.12 $</h4>
                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="text-center">
                    <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid rounded" alt="">
                    <div class="py-4">
                        <a href="#" class="h5">Organic Tomato</a>
                        <div class="d-flex my-3 justify-content-center">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="mb-3">3.12 $</h4>
                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="text-center">
                    <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid rounded" alt="">
                    <div class="py-4">
                        <a href="#" class="h5">Organic Tomato</a>
                        <div class="d-flex my-3 justify-content-center">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="mb-3">3.12 $</h4>
                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="text-center">
                    <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid rounded" alt="">
                    <div class="py-2">
                        <a href="#" class="h5">Organic Tomato</a>
                        <div class="d-flex my-3 justify-content-center">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="mb-3">3.12 $</h4>
                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bestsaler Product End -->

@endsection

@extends('layouts.customer.master')

@section('content')


<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row g-4 mb-5">
            <div class="col-lg-8 col-xl-9">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="border rounded">
                            @if($product->images->count() > 1)
                                <!-- Bootstrap Carousel for multiple images -->
                                <div id="productCarousel{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($product->images as $key => $image)
                                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                <img src="{{ asset($image->image) }}" class="d-block w-100 rounded" alt="{{ $product->name }}">
                                            </div>
                                        @endforeach
                                
                                        @if($product->videos->isNotEmpty())
                                            <div class="carousel-item">
                                                <video class="d-block w-100 rounded" controls>
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
                                <a href="#">
                                    <img src="{{ asset($product->images->first()->image) }}" class="img-fluid rounded mb-2" alt="{{ $product->name }}">
                                </a>
                            @else
                                <!-- Fallback image if no images exist -->
                                <a href="#">
                                    <img src="https://gsacommerce.com/assets/frontend/image/gsa-logo.svg" class="img-fluid rounded" alt="No Image">
                                </a>
                            @endif
                        </div>
                    </div>
                                        
                    <div class="col-lg-6">
                        <h4 class="fw-bold mb-3">{{ $product->name }}</h4>
                        <p class="mb-3">Category: {{ $product->category->name }}</p>
                        @if($product->discount_price)
                                <h5 class="fw-bold mb-3">
                                    <span class="text-decoration-line-through text-muted">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                    <span class="text-danger fw-bold" style="font-size: 12px;">
                                        {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% off
                                    </span> <br>
                                    <span class="text-danger fw-bold mb-2">Rp{{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                </h5>
                            @else
                                <h5 class="fw-bold mb-3">Rp{{ number_format($product->price, 0, ',', '.') }}</h5>
                            @endif
                        <div class="d-flex mb-4">
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <p class="mb-4">{{ $product->description }}</p>
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
                        </div>
                        
                        <!-- Success Message -->
                            <!-- Notifikasi untuk Keranjang -->
                        <div id="cart-message" class="cart-notification d-none" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(30, 30, 30, 0.9); color: white; padding: 20px 30px; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5); z-index: 1000; font-size: 18px;">
                            <div class="notification-content" style="display: flex; align-items: center; width: 100%;">
                                <span class="notification-icon" style="font-size: 30px; margin-right: 15px;">🎉</span>
                                <span class="notification-text" style="flex-grow: 1; font-weight: bold;">Product added to cart successfully!</span>
                                <button onclick="this.parentElement.parentElement.style.display='none'" style="background: transparent; border: none; color: white; cursor: pointer; font-size: 22px; margin-left: 15px;">&times;</button>
                            </div>
                        </div>

                        
                        
                        
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
                        
                    </div>
                    <div class="col-lg-12">
                        <nav>
                            <div class="nav nav-tabs mb-3">
                                <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                    id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                    aria-controls="nav-about" aria-selected="true">Specification</button>
                                <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                    id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                    aria-controls="nav-mission" aria-selected="false">Reviews</button>
                            </div>
                        </nav>
                        <div class="tab-content mb-5">
                            <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                <p>{!! $product->specification !!}</p>
                            </div>
                            <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                                <div class="d-flex">
                                    <img src="img/avatar.jpg" class="img-fluid rounded-circle p-3" style="width: 100px; height: 100px;" alt="">
                                    <div class="">
                                        <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                        <div class="d-flex justify-content-between">
                                            <h5>Jason Smith</h5>
                                            <div class="d-flex mb-3">
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                        <p>The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic 
                                            words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <img src="img/avatar.jpg" class="img-fluid rounded-circle p-3" style="width: 100px; height: 100px;" alt="">
                                    <div class="">
                                        <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                        <div class="d-flex justify-content-between">
                                            <h5>Sam Peters</h5>
                                            <div class="d-flex mb-3">
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                        <p class="text-dark">The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic 
                                            words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="nav-vision" role="tabpanel">
                                <p class="text-dark">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor sit. Aliqu diam
                                    amet diam et eos labore. 3</p>
                                <p class="mb-0">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos labore.
                                    Clita erat ipsum et lorem et sit</p>
                            </div>
                        </div>
                    </div>
                    {{-- <form action="#">
                        <h4 class="mb-5 fw-bold">Leave a Reply</h4>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="border-bottom rounded">
                                    <input type="text" class="form-control border-0 me-4" placeholder="Yur Name *">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="border-bottom rounded">
                                    <input type="email" class="form-control border-0" placeholder="Your Email *">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="border-bottom rounded my-4">
                                    <textarea name="" id="" class="form-control border-0" cols="30" rows="8" placeholder="Your Review *" spellcheck="false"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between py-3 mb-5">
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 me-3">Please rate:</p>
                                        <div class="d-flex align-items-center" style="font-size: 12px;">
                                            <i class="fa fa-star text-muted"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <a href="#" class="btn border border-secondary text-primary rounded-pill px-4 py-3"> Post Comment</a>
                                </div>
                            </div>
                        </div>
                    </form> --}}
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
                                            <a href="#">
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
                                        <div class="d-flex mb-2">
                                            <!-- Assuming product has a 'rating' field -->
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star {{ $i <= $product->rating ? 'text-secondary' : '' }}"></i>
                                            @endfor
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
                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded" alt="">
                            <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
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
        
                                    <!-- Rating and Purchase Info -->
                                    <div class="d-flex justify-content-start align-items-center">
                                        <span class="text-muted small">
                                            <i class="fa fa-star text-warning me-1"></i>
                                            {{ $relatedProduct->rating ?? '0.0' }}
                                        </span>
                                        <span class="mx-2">|</span>
                                        <span class="text-muted small">70+ terjual</span>
                                    </div>
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
                <a href="" class="btn btn-primary px-5 py-2 rounded-pill text-white" style="font-size: 16px;">Lainnya</a>
            </div>
        </div>
        
        
        
    </div>
</div>

<script>
    $(document).ready(function(){
    $('.owl-carousel').owlCarousel({
        loop: true,           // Loop through items
        margin: 10,           // Space between items
        nav: true,            // Show navigation buttons
        dots: false,          // Hide dots
        autoplay: false,      // Auto-play the carousel
        navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],  // Custom icons for nav buttons
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    });
});

</script>

@endsection
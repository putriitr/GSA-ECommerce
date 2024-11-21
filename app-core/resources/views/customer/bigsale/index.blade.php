@extends('layouts.customer.master')
@section('content')

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5"
    style="position: relative; overflow: hidden; background: url('{{ asset('storage/img/cart-header-bg.jpg') }}') no-repeat center center; background-size: cover; width: 100%;">
    <div style="background: rgba(0, 0, 0, 0.096); position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1;">
    </div>
    <h1 class="text-center display-6 text-dark" style="position: relative; z-index: 2;">{{ $bigSales->title }}</h1>
    <ol class="breadcrumb justify-content-center mb-0" style="position: relative; z-index: 2;">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark">{{ __('shop.breadcrumb_home') }}</a></li>
        <li class="breadcrumb-item active text-primary">{{ __('Big Sales') }}</li>
        <li class="breadcrumb-item active text-primary">{{ $bigSales->title }}</li>
    </ol>
</div>
<!-- Single Page Header End -->

<div class="container-fluid fruite">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4 mb-4 align-items-center">
                    <!-- Filter Message -->
                    @if(!empty($filterMessage))
                    <div class="col-xl-9">
                        <div class="filter-message w-100 mx-auto d-flex align-items-center justify-content-between">
                            <p class="text-muted mb-0 d-flex align-items-center">
                                <i class="fas fa-filter me-2"></i>
                                <span>{{ __('shop.filter_applied', ['message' => implode(', ', $filterMessage)]) }}</span>
                            </p>
                            <!-- Ikon Refresh -->
                            <a href="{{ route('customer.bigsale.index', ['slug' => $bigSales->slug]) }}" class="btn btn-secondary" style="background: none; border: none; padding: 0;">
                                <i class="fas fa-sync-alt" style="font-size: 18px; color: #007bff;" aria-label="{{ __('shop.refresh') }}"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-xl-3">
                        <div class="sorting-dropdown bg-light px-3 py-2 rounded d-flex justify-content-between align-items-center shadow-sm">
                            <label for="fruits" class="me-2 mb-0 text-dark" style="font-weight: 500; white-space: nowrap;">{{ __('shop.sort_by') }}</label>
                            <select id="sort" name="sort" class="border-0 form-select bg-white text-dark rounded w-100" style="min-width: 150px;"
                            onchange="location.href = '{{ route('customer.bigsale.index', ['slug' => $bigSales->slug]) }}' + '?sort=' + this.value;">
                                            <option value="terbaru" {{ request()->get('sort') == 'terbaru' ? 'selected' : '' }}>{{ __('shop.newest') }}</option>
                                <option value="terlama" {{ request()->get('sort') == 'terlama' ? 'selected' : '' }}>{{ __('shop.oldest') }}</option>
                            </select>
                        </div>
                    </div>
                @else
                    <div class="col-xl-12 d-flex justify-content-end">
                        <div class="sorting-dropdown bg-light px-3 py-2 rounded d-flex justify-content-between align-items-center shadow-sm">
                            <label for="fruits" class="me-2 mb-0 text-dark" style="font-weight: 500; white-space: nowrap;">{{ __('shop.sort_by') }}</label>
                            <select id="sort" name="sort" class="border-0 form-select bg-white text-dark rounded w-100" style="min-width: 150px;"
                            onchange="location.href = '{{ route('customer.bigsale.index', ['slug' => $bigSales->slug]) }}' + '?sort=' + this.value;">
                                            <option value="terbaru" {{ request()->get('sort') == 'terbaru' ? 'selected' : '' }}>{{ __('shop.newest') }}</option>
                                <option value="terlama" {{ request()->get('sort') == 'terlama' ? 'selected' : '' }}>{{ __('shop.oldest') }}</option>
                            </select>
                        </div>
                    </div>
                @endif

            </div>
                
                
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4>{{ __('shop.categories') }}</h4>
                                    <ul class="list-unstyled fruite-categorie">
                                        @foreach($categories as $category)
                                            @php
                                                $productCount = $bigSales->products->where('category_id', $category->id)->count();
                                            @endphp
                                            @if($productCount > 0)
                                                <li>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a href="{{ route('customer.bigsale.index', ['slug' => $bigSales->slug, 'category' => $category->id, 'sort' => request()->get('sort')]) }}" 
                                                           class="{{ request()->get('category') == $category->id ? 'text-primary' : '' }}">
                                                           <i class="fas fa-tools me-2"></i>{{ $category->name }}
                                                        </a>
                                                        <span>({{ $productCount }})</span>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>                                                                     
                                </div>
                                                        
                            </div>
                            
                            <div class="col-lg-12 mt-5">
                                <div class="position-relative">
                                    @php
                                        $microBannerShop = \App\Models\BannerMicro::where('page', 'shop')->where('active', true)->first();
                                    @endphp
                                    
                                    <a href="{{ $microBannerShop ? $microBannerShop->link : '#' }}" target="_blank">
                                        <img src="{{ $microBannerShop ? asset($microBannerShop->image) : asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded" alt="">
                                    </a>
                            
                                    <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                                        <!-- Additional content can be placed here -->
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row g-4 justify-content-start">
                            @if($bigSales)
                                <div class="countdown__timer">
                                    <div class="col-lg-12 text-center">
                                        <!-- Big Sale Title -->
                                        <h2 class="bigsale-title" style="color: #444; margin-bottom: 20px; font-weight: bold;">
                                            {{ $bigSales->title }}
                                        </h2>
                                        
                                        <!-- Countdown Timer -->
                                        <div class="row clock-wrap justify-content-center" style="gap: 10px;">
                                            <!-- Days Box -->
                                            <div class="col clockinner1 clockinner" style="border-radius: 10px; background-color: #f5f5f5; padding: 15px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                <h1 id="days" class="days" style="color: #333; font-size: 1.8em; font-weight: bold;">00</h1>
                                                <span class="smalltext" style="color: #666;">{{ __('messages.days') }}</span>
                                            </div>
                                            <!-- Hours Box -->
                                            <div class="col clockinner clockinner1" style="border-radius: 10px; background-color: #f5f5f5; padding: 15px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                <h1 id="hours" class="hours" style="color: #333; font-size: 1.8em; font-weight: bold;">00</h1>
                                                <span class="smalltext" style="color: #666;">{{ __('messages.hours') }}</span>
                                            </div>
                                            <!-- Minutes Box -->
                                            <div class="col clockinner clockinner1" style="border-radius: 10px; background-color: #f5f5f5; padding: 15px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                <h1 id="minutes" class="minutes" style="color: #333; font-size: 1.8em; font-weight: bold;">00</h1>
                                                <span class="smalltext" style="color: #666;">{{ __('messages.minutes') }}</span>
                                            </div>
                                            <!-- Seconds Box -->
                                            <div class="col clockinner clockinner1" style="border-radius: 10px; background-color: #f5f5f5; padding: 15px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                                <h1 id="seconds" class="seconds" style="color: #333; font-size: 1.8em; font-weight: bold;">00</h1>
                                                <span class="smalltext" style="color: #666;">{{ __('messages.seconds') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <script>
                                        const bigSaleEndTime = new Date("{{ date('Y-m-d\\TH:i:s', strtotime($bigSales->end_time)) }}").getTime();
                                        
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
                                </div>
                            @endif
                        </div>
                        <div class="row mt-5">
                            @if($bigSales->products->isEmpty())
                                <p class="text-muted">{{ __('shop.no_products') }}</p>
                            @else
                                @foreach($bigSales->products as $product)
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <a href="{{ $product->stock > 0 ? route('customer.product.show', $product->slug). '?promo=big-sale&location=bekasi' : 'javascript:void(0);' }}" 
                                           class="text-decoration-none" 
                                           style="color: inherit; pointer-events: {{ $product->stock > 0 ? 'auto' : 'none' }};">
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
                                                    @php
                                                        $finalPrice = $product->price;
                                                        if ($bigSales->discount_amount) {
                                                            $finalPrice -= $bigSales->discount_amount;
                                                        } elseif ($bigSales->discount_percentage) {
                                                            $finalPrice -= ($bigSales->discount_percentage / 100) * $product->price;
                                                        }
                                                        $discountPercentage = $bigSales->discount_percentage 
                                                            ? $bigSales->discount_percentage 
                                                            : (($product->price - $finalPrice) / $product->price) * 100;
                                                    @endphp
                        
                                                    @if($finalPrice < $product->price)
                                                        <p class="text-dark text-start fs-6 mb-2">
                                                            <span class="text-decoration-line-through text-muted">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                                            <span class="text-danger fw-bold" style="font-size: 12px;">
                                                                {{ __('shop.discount', ['percentage' => round($discountPercentage)]) }}
                                                            </span> <br>
                                                            <span class="text-danger fw-bold mb-2">Rp{{ number_format($finalPrice, 0, ',', '.') }}</span>
                                                        </p>
                                                    @else
                                                        <p class="text-dark text-start fs-6 mb-2">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                                    @endif
                        
                                                    <!-- Rating and Purchase Info -->
                                                    <div class="d-flex justify-content-start align-items-center">
                                                        <span class="text-muted small">
                                                            <i class="fa fa-star text-warning me-1"></i>
                                                            {{ $product->rating ?? '0.0' }}
                                                        </span>
                                                        <span class="mx-2">|</span>
                                                        <span class="text-muted small">{{ __('shop.sold', ['count' => $product->completed_order_count ?? 0]) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AJAX for Add to Cart -->
<script>
    document.querySelectorAll('.add-to-cart-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var productId = this.dataset.id;
            var token = '{{ csrf_token() }}';

            fetch('{{ route('cart.add', '') }}/' + productId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    quantity: 1 // Default quantity, you can customize this if needed
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Display notification
                    var notification = document.getElementById('cart-notification');
                    notification.style.display = 'flex';
                    setTimeout(() => {
                        notification.style.display = 'none';
                    }, 3000);  // Notification disappears after 3 seconds
                } else {
                    alert('Failed to add product to cart: ' + (data.message || 'Unknown error.'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to add product to cart!');
            });
        });
    });

    // Countdown Timer Script
    @if($bigSales)
    function startCountdown(endTime) {
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                clearInterval(countdownInterval);
                document.getElementById('days').textContent = '00';
                document.getElementById('hours').textContent = '00';
                document.getElementById('minutes').textContent = '00';
                document.getElementById('seconds').textContent = '00';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = String(days).padStart(2, '0');
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
        }

        const countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown();
    }

    const bigSaleEndTime = new Date("{{ date('Y-m-d\TH:i:s', strtotime($bigSales->berakhir)) }}").getTime();
    startCountdown(bigSaleEndTime);
    @endif
</script>


<script>
    function formatPrice(input) {
        // Hapus semua karakter kecuali angka
        let value = input.value.replace(/\D/g, '');
    
        // Tambahkan titik setiap 3 angka
        input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
    
@endsection

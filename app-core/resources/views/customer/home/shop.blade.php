@extends('layouts.customer.master')

@section('content')


<!-- Single Page Header start -->
<div class="container-fluid page-header py-5"
    style="position: relative; overflow: hidden; background: url('{{ asset('storage/img/cart-header-bg.jpg') }}') no-repeat center center; background-size: cover; width: 100%;">
    <div style="background: rgba(0, 0, 0, 0.096); position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1;">
    </div>
    <h1 class="text-center display-6 text-dark" style="position: relative; z-index: 2;">{{ __('shop.page_title') }}</h1>
    <ol class="breadcrumb justify-content-center mb-0" style="position: relative; z-index: 2;">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark">{{ __('shop.breadcrumb_home') }}</a></li>
        <li class="breadcrumb-item active text-primary">{{ __('shop.breadcrumb_shop') }}</li>
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
                                <span>{{ __('shop.filter_applied', ['message' => $filterMessage]) }}</span>
                            </p>
                            <!-- Ikon Refresh -->
                            <a href="{{ route('shop') }}" class="btn btn-secondary" style="background: none; border: none; padding: 0;">
                                <i class="fas fa-sync-alt" style="font-size: 18px; color: #007bff;" aria-label="{{ __('shop.refresh') }}"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-xl-3">
                        <div class="sorting-dropdown bg-light px-3 py-2 rounded d-flex justify-content-between align-items-center shadow-sm">
                            <label for="fruits" class="me-2 mb-0 text-dark" style="font-weight: 500; white-space: nowrap;">{{ __('shop.sort_by') }}</label>
                            <select id="fruits" name="fruitlist" class="border-0 form-select bg-white text-dark rounded w-100" style="min-width: 150px;">
                                <option value="terbaru" {{ request()->get('sort') == 'terbaru' ? 'selected' : '' }}>{{ __('shop.newest') }}</option>
                                <option value="terlama" {{ request()->get('sort') == 'terlama' ? 'selected' : '' }}>{{ __('shop.oldest') }}</option>
                                <option value="termahal" {{ request()->get('sort') == 'termahal' ? 'selected' : '' }}>{{ __('shop.most_expensive') }}</option>
                                <option value="termurah" {{ request()->get('sort') == 'termurah' ? 'selected' : '' }}>{{ __('shop.cheapest') }}</option>
                            </select>
                        </div>
                    </div>
                @else
                    <div class="col-xl-12 d-flex justify-content-end">
                        <div class="sorting-dropdown bg-light px-3 py-2 rounded d-flex justify-content-between align-items-center shadow-sm">
                            <label for="fruits" class="me-2 mb-0 text-dark" style="font-weight: 500; white-space: nowrap;">{{ __('shop.sort_by') }}</label>
                            <select id="fruits" name="fruitlist" class="border-0 form-select bg-white text-dark rounded w-100" style="min-width: 150px;">
                                <option value="terbaru" {{ request()->get('sort') == 'terbaru' ? 'selected' : '' }}>{{ __('shop.newest') }}</option>
                                <option value="terlama" {{ request()->get('sort') == 'terlama' ? 'selected' : '' }}>{{ __('shop.oldest') }}</option>
                                <option value="termahal" {{ request()->get('sort') == 'termahal' ? 'selected' : '' }}>{{ __('shop.most_expensive') }}</option>
                                <option value="termurah" {{ request()->get('sort') == 'termurah' ? 'selected' : '' }}>{{ __('shop.cheapest') }}</option>
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
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="{{ route('shop', ['category_id' => $category->id, 'sort' => request()->get('sort')]) }}" 
                                                   class="{{ request()->get('category_id') == $category->id ? 'text-primary' : '' }}">
                                                   <i class="fas fa-tools me-2"></i>{{ $category->name }}
                                                </a>
                                                <span>({{ $category->products->count() }})</span>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>                                                                     
                                </div>                                
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4 class="mb-2">{{ __('shop.price_filter') }}</h4>
                                    <form action="{{ route('shop') }}" method="GET">
                                        <input type="hidden" name="category_id" value="{{ request()->get('category_id') }}">
                                        <div class="d-flex flex-column">
                                            <div class="mb-3">
                                                <label for="min_price">{{ __('shop.min_price') }}</label>
                                                <input type="text" class="form-control" id="min_price" name="min_price" value="{{ request()->get('min_price') }}" placeholder="0" oninput="formatPrice(this)">
                                            </div>
                                            <div class="mb-3">
                                                <label for="max_price">{{ __('shop.max_price') }}</label>
                                                <input type="text" class="form-control" id="max_price" name="max_price" value="{{ request()->get('max_price') }}" placeholder="..." oninput="formatPrice(this)">
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <button type="submit" class="btn btn-primary mt-3">{{ __('shop.filter') }}</button>
                                                <a href="{{ route('shop') }}" class="btn btn-secondary mt-3" style="background: none; border: none; padding: 0;">
                                                    <i class="fas fa-sync-alt" style="font-size: 24px;" aria-label="{{ __('shop.refresh') }}"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
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
                            @if($products->isEmpty())
                                <p class="text-muted">{{ __('shop.no_products') }}</p>
                            @else
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
                                                        <span class="text-muted small">
                                                            <i class="fa fa-star text-warning me-1"></i>
                                                            {{ $product->rating ?? '0.0' }}
                                                        </span>
                                                        <span class="mx-2">|</span>
                                                        <span class="text-muted small">{{ __('shop.sold', ['count' => $product->completed_order_count]) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                        <style>
                            
    /* Custom Pagination Styling */
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
}

.pagination li {
    margin: 0 5px;
}

.pagination a,
.pagination span {
    display: inline-block;
    padding: 8px 16px;
    font-size: 0.9rem;
    color: #007bff;
    text-decoration: none;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    background-color: #ffffff;
    transition: all 0.3s ease;
}

.pagination a:hover,
.pagination .active span {
    background-color: #007bff;
    color: #ffffff;
    border-color: #007bff;
}

.pagination .disabled span {
    color: #6c757d;
    background-color: #f8f9fa;
    border-color: #dee2e6;
}
                        </style>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    document.getElementById('fruits').addEventListener('change', function() {
    var selectedValue = this.value;
    var currentUrl = window.location.href;
    var categoryId = new URL(currentUrl).searchParams.get('category_id'); // Ambil category_id dari URL
    var newUrl = updateURLParameter(currentUrl, 'sort', selectedValue);
    if (categoryId) {
        newUrl = updateURLParameter(newUrl, 'category_id', categoryId); // Tambahkan kategori jika ada
    }
    window.location.href = newUrl;
});

function updateURLParameter(url, param, paramVal) {
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = "";

    if (additionalURL) {
        tempArray = additionalURL.split("&");
        for (var i = 0; i < tempArray.length; i++) {
            if (tempArray[i].split('=')[0] != param) {
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }
    }

    var rows_txt = temp + "" + param + "=" + paramVal;
    return baseURL + "?" + newAdditionalURL + rows_txt;
}

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
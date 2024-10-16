@extends('layouts.customer.master')

@section('content')


 <!-- Single Page Header start -->
 <div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Shop</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active text-white">Shop</li>
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
                                <span>{{ $filterMessage }}</span>
                            </p>
                            <!-- Ikon Refresh -->
                            <a href="{{ route('shop') }}" class="btn btn-secondary" style="background: none; border: none; padding: 0;">
                                <i class="fas fa-sync-alt" style="font-size: 18px; color: #007bff;"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-xl-3">
                        <div class="sorting-dropdown bg-light px-3 py-2 rounded d-flex justify-content-between align-items-center shadow-sm">
                            <label for="fruits" class="me-2 mb-0 text-dark" style="font-weight: 500; white-space: nowrap;">Sort By:</label>
                            <select id="fruits" name="fruitlist" class="border-0 form-select bg-white text-dark rounded w-100" style="min-width: 150px;">
                                <option value="terbaru" {{ request()->get('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="terlama" {{ request()->get('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                                <option value="termahal" {{ request()->get('sort') == 'termahal' ? 'selected' : '' }}>Termahal</option>
                                <option value="termurah" {{ request()->get('sort') == 'termurah' ? 'selected' : '' }}>Termurah</option>
                            </select>
                        </div>
                    </div>
                    @else
                    <div class="col-xl-12 d-flex justify-content-end">
                        <div class="sorting-dropdown bg-light px-3 py-2 rounded d-flex justify-content-between align-items-center shadow-sm">
                            <label for="fruits" class="me-2 mb-0 text-dark" style="font-weight: 500; white-space: nowrap;">Sort By:</label>
                            <select id="fruits" name="fruitlist" class="border-0 form-select bg-white text-dark rounded w-100" style="min-width: 150px;">
                                <option value="terbaru" {{ request()->get('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="terlama" {{ request()->get('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                                <option value="termahal" {{ request()->get('sort') == 'termahal' ? 'selected' : '' }}>Termahal</option>
                                <option value="termurah" {{ request()->get('sort') == 'termurah' ? 'selected' : '' }}>Termurah</option>
                            </select>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Custom CSS -->
                <style>
                    


                </style>
                
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4>Categories</h4>
                                    <ul class="list-unstyled fruite-categorie">
                                        @foreach($categories as $category)
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="{{ route('shop', ['category_id' => $category->id, 'sort' => request()->get('sort')]) }}" 
                                                   class="{{ request()->get('category_id') == $category->id ? 'text-primary' : '' }}">
                                                    <i class="fas fa-apple-alt me-2"></i>{{ $category->name }}
                                                </a>
                                                <span>({{ $category->products_count }})</span>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>                                                                     
                                </div>                                
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4 class="mb-2">Price Filter</h4>
                                    <form action="{{ route('shop') }}" method="GET">
                                        <input type="hidden" name="category_id" value="{{ request()->get('category_id') }}">
                                        <div class="d-flex flex-column">
                                            <div class="mb-3">
                                                <label for="min_price">Min Price</label>
                                                <input type="text" class="form-control" id="min_price" name="min_price" value="{{ request()->get('min_price') }}" placeholder="0" oninput="formatPrice(this)">
                                            </div>
                                            <div class="mb-3">
                                                <label for="max_price">Max Price</label>
                                                <input type="text" class="form-control" id="max_price" name="max_price" value="{{ request()->get('max_price') }}" placeholder="..." oninput="formatPrice(this)">
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <button type="submit" class="btn btn-primary mt-3">Filter</button>
                                                <!-- Ikon Refresh -->
                                                <a href="{{ route('shop') }}" class="btn btn-secondary mt-3" style="background: none; border: none; padding: 0;">
                                                    <i class="fas fa-sync-alt" style="font-size: 24px;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>                            
                            
                            <div class="col-lg-12 mt-5">
                                <div class="position-relative">
                                    @php
                                        // Fetch the active micro banner for the shop page
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
                                <p class="text-muted">Tidak ada produk yang ditemukan dalam kategori ini.</p> <!-- Pesan jika tidak ada produk -->
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
                                                        <span class="text-muted small">
                                                            <i class="fa fa-star text-warning me-1"></i>
                                                            {{ $product->rating ?? '0.0' }}
                                                        </span>
                                                        <span class="mx-2">|</span>
                                                        <span class="text-muted small">{{ $product->completed_order_count }}+ terjual</span>
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
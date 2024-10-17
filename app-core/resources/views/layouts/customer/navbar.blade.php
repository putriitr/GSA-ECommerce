<div class="container-fluid fixed-top">
    <div class="container-fluid topbar bg-primary d-none d-lg-block px-5">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3">
                    <i class="fas fa-phone-alt me-2 text-secondary"></i> <!-- Ikon telepon -->
                    <a href="tel:+6281390069009" class="text-white">{{ $parameter->nomor_wa }}</a>
                </small>
                <small class="me-3">
                    <i class="fas fa-envelope me-2 text-secondary"></i> <!-- Ikon email -->
                    <a href="mailto:info@gsacommerce.com" class="text-white">{{ $parameter->email }}</a>
                </small>
            </div>
            
            <div class="top-link pe-2">
                <a href="#" class="text-white"><small class="text-white mx-2">{{ $parameter->slogan_welcome }}</small></a>
            </div>
        </div>
    </div>
    <div class="container px-5">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="{{ route('home') }}" class="navbar-brand brand-logo" style="padding-right: 10px;">
                <img src="{{ asset($parameter->logo) }}" alt="Logo Ecommerce" style="height: 40px;">
            </a>
            
            <!-- Logo Cinta Produk Indonesia di kanan -->
            <a href="{{ route('home') }}" target="_blank" class="brand-logo-right">
                <img src="{{ asset($parameter->logo_tambahan) }}" alt="Cinta Produk Indonesia" style="height: 40px;">
            </a>
            
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <!-- Form Pencarian -->
                    <form action="{{ route('shop') }}" method="GET" class="d-none d-lg-flex align-items-center search-bar w-100" style="background-color: white; border-radius: 50px; padding: 5px;">
                        <!-- Dropdown for Product Categories -->
                        <div class="dropdown me-2">
                            <button class="btn btn-light dropdown-toggle rounded-pill px-3" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <span id="categoryLabel">
                                    <!-- If category exists in request, display the selected category name, else default to "Semua Produk" -->
                                    {{ $selectedCategoryName ?? 'Semua Produk' }}
                                </span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="selectCategory(null, '{{ __('navbar.all_products') }}')">
                                        {{ __('navbar.all_products') }}
                                    </a>
                                </li>
                                                                @foreach($categories as $category)
                                    <li><a class="dropdown-item" href="#" onclick="selectCategory({{ $category->id }}, '{{ $category->name }}')">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Hidden input for category -->
                        <input type="hidden" name="category_id" id="categoryInput" value="{{ request()->get('category_id') }}">
                        <!-- Search Input -->
                        <input type="text" class="form-control border-0 rounded-pill px-4 py-2" placeholder="Cari Barang Impian Kamu Disini" name="keyword" value="{{ request()->get('keyword') }}">
                        <!-- Search Button -->
                        <button class="btn mx-2" type="submit" style="width: 40px; height: 40px;">
                            <i class="fas fa-search text-dark"></i>
                        </button>
                    </form>
                </div>
                
                <script>
                    function selectCategory(categoryId, categoryName) {
                        document.getElementById('categoryInput').value = categoryId;
                        document.getElementById('categoryLabel').innerText = categoryName;
                    }
                </script>
                
                
                
    
                <div class="d-flex m-3 me-0">
                    @if(Auth::check())
                        <!-- Jika user sudah login, tampilkan ikon Cart dan Wishlist -->
                        <a href="{{ route('cart.show') }}" class="position-relative me-4 my-auto mx-2">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                            @php
                                // Get the count of items in the cart for the logged-in user
                                $cartCount = Auth::check() ? \App\Models\Cart::where('user_id', Auth::id())->count() : 0;
                            @endphp
                            @if ($cartCount > 0)
                                <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                        
                        <!-- Wishlist Icon -->
                        <a href="{{ route('wishlist.index') }}" class="position-relative me-4 my-auto mx-2">
                            <i class="fas fa-heart fa-2x text-primary"></i>
                            @php
                                // Get the count of items in the wishlist for the logged-in user
                                $wishlistCount = Auth::check() ? \App\Models\Wishlist::where('user_id', Auth::id())->count() : 0;
                            @endphp
                            @if ($wishlistCount > 0)
                                <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">
                                    {{ $wishlistCount }}
                                </span>
                            @endif
                        </a>                        
                
                        <!-- Separator -->
                        <span class="mx-2">|</span>
                
                        <!-- Tampilkan nama pengguna -->
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center my-auto dropdown-toggle text-dark" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user fa-2x me-2 text-primary"></i>
                                <span class="d-none d-md-inline">Halo, {{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg rounded-lg" aria-labelledby="dropdownUser" style="min-width: 200px; border-radius: 15px;">
                                <!-- Profile Section -->
                                <li class="text-center">
                                    <div class="p-3 border-bottom">
                                        <!-- Check if the user has a profile photo, otherwise display a default image -->
                                        <img src="{{ Auth::user()->profile_photo ? asset(Auth::user()->profile_photo) : asset('assets/default/image/user.png') }}" 
                                             alt="{{ Auth::user()->name }}" 
                                             class="rounded-circle" 
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                        <p class="mb-0 mt-2 fw-bold">{{ Auth::user()->name }}</p>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </div>
                                </li>
                                
                                
                                <!-- Links -->
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('user.profile.show') }}">
                                        <i class="fas fa-user me-2"></i> {{ __('navbar.profile') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('customer.orders.index') }}">
                                        <i class="fas fa-box me-2"></i> {{ __('navbar.orders') }}
                                    </a>
                                </li>
                                
                                <li><hr class="dropdown-divider"></li>
                                <!-- Logout Option -->
                                <li>
                                    <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                        
                        
                    @else
                    <a href="#" class="position-relative me-4 my-auto mx-2 btn-open-modal2">
                        <i class="fa fa-shopping-bag fa-2x"></i>
                        <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">
                            !
                        </span>
                    </a>
                    
                    <span class="mx-2">|</span>

                        <!-- Jika user belum login, tampilkan tombol Masuk dan Daftar -->
                        <a href="#" class="btn btn-primary mx-2 btn-open-modal">Masuk</a>
                        @include('auth.modal.login')
                        

                        <a href="{{ route('register') }}" class="btn btn-secondary mx-2">Daftar</a>
                    @endif
                </div>
                
            </div>
        </nav>

        <style>
            
        </style>
    </div>
</div>




    



@include('layouts.customer.bottom-navbar')






<div class="container-fluid fixed-top">
    <div class="container-fluid topbar bg-primary d-none d-lg-block px-5">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3">
                    <i class="fas fa-phone-alt me-2 text-secondary"></i> <!-- Ikon telepon -->
                    <a href="tel:+6281390069009" class="text-white">+62813 9006 9009</a>
                </small>
                <small class="me-3">
                    <i class="fas fa-envelope me-2 text-secondary"></i> <!-- Ikon email -->
                    <a href="mailto:info@gsacommerce.com" class="text-white">info@gsacommerce.com</a>
                </small>
            </div>
            
            <div class="top-link pe-2">
                <a href="#" class="text-white"><small class="text-white mx-2">Selamat datang di Toko GS acommerce</small></a>
            </div>
        </div>
    </div>
    <div class="container px-5">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="{{ route('home') }}" class="navbar-brand brand-logo" style="padding-right: 10px;">
                <img src="https://gsacommerce.com/assets/frontend/image/gsa-logo.svg" alt="Logo Ecommerce" style="height: 40px;">
            </a>
            
            <!-- Logo Cinta Produk Indonesia di kanan -->
            <a href="https://banggabuatanindonesia.co.id/" target="_blank" class="brand-logo-right">
                <img src="https://kemenparekraf.go.id/_next/image?url=https%3A%2F%2Fapi2.kemenparekraf.go.id%2Fstorage%2Fapp%2Fuploads%2Fpublic%2F621%2F436%2Ff46%2F621436f463b3f837489693.png&w=3840&q=75" alt="Cinta Produk Indonesia" style="height: 40px;">
            </a>
            
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <!-- Form Pencarian -->
                    <form class="d-none d-lg-flex align-items-center search-bar w-100" style="background-color: white; border-radius: 50px; padding: 5px;">
                        <!-- Dropdown for Product Categories -->
                        <div class="dropdown me-2">
                            <button class="btn btn-light dropdown-toggle rounded-pill px-3" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Semua Produk
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#">Kategori 1</a></li>
                                <li><a class="dropdown-item" href="#">Kategori 1</a></li>
                                <li><a class="dropdown-item" href="#">Kategori 1</a></li>
                            </ul>
                        </div>
                        <!-- Search Input -->
                        <input type="text" class="form-control border-0 rounded-pill px-4 py-2" placeholder="Cari Barang Impian Kamu Disini">
                        <!-- Search Button -->
                        <button class="btn  mx-2" type="submit" style="width: 40px; height: 40px;">
                            <i class="fas fa-search text-dark"></i>
                        </button>
                    </form>
                </div>
    
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
                        <a href="#" class="position-relative me-4 my-auto mx-2">
                            <i class="fas fa-heart fa-2x text-primary"></i>
                            <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">
                                5
                            </span>
                        </a>
                
                        <!-- Separator -->
                        <span class="mx-2">|</span>
                
                        <!-- Tampilkan nama pengguna -->
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center my-auto dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user fa-2x me-2"></i>
                                <span class="d-none d-md-inline">Halo, {{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                                <!-- Option for viewing profile or other options can be added here -->
                                <li><a class="dropdown-item" href="{{ route('user.profile.show') }}">Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <!-- Logout Option -->
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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




<!-- Modal Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center">
                <div class="input-group w-75 mx-auto d-flex">
                    <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Search End -->



@include('layouts.customer.bottom-navbar')






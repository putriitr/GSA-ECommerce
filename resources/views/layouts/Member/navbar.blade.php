        <!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <div class="container topbar bg-primary d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Bekasi, Jawa Barat</a></small>
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="mailto:info@gsacommerce.com" class="text-white">info@gsacommerce.com</a></small>
                        <small class="me-3"><i class="fas fa-phone me-2 text-secondary"></i><a href="https://wa.me/6281390069009" class="text-white">+62 813-9006-9009</a></small>
                    </div>
                    <div class="top-link pe-2">
                        <a href="#" class="text-white"><small class="text-white mx-2">Innovation for Construction</small>|</a>
                        <a href="#" class="text-white"><small class="text-white mx-2">Indonesia</small></a>
                    </div>
                </div>
            </div>
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                    <a href="index.html" class="navbar-brand">
                        <img src="{{ asset('storage/img/logo-gsa2.png')}}" alt="Fruitables Logo" style="height: 100px;">
                    </a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                            <a href="{{ route('home')}}" class="nav-item nav-link">Home</a>
                            <a href="{{ route('shop')}}" class="nav-item nav-link">Shop</a>
                            {{-- <a href="shop-detail.html" class="nav-item nav-link">Shop Detail</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Shop</a>
                                <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                    <a href="cart.html" class="dropdown-item">Shop</a>
                                    <a href="chackout.html" class="dropdown-item">Cart</a>
                                    <a href="testimonial.html" class="dropdown-item">Checkout</a>
                                    {{-- <a href="404.html" class="dropdown-item">404 Page</a>
                                </div>
                            </div> --}}
                            <a href="{{ route('contact')}}" class="nav-item nav-link">Contact</a>
                        </div>
                        <div class="d-flex m-3 me-0">
                            <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                            <a href="{{ route('wishlist')}}" class="position-relative me-4 my-auto">
                                <i class="fa fa-heart fa-2x"></i>
                                <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 22px; height: 20px; min-width: 20px;">5</span>
                            </a>
                            <a href="{{ route('cart')}}" class="position-relative me-4 my-auto">
                                <i class="fa fa-shopping-cart fa-2x"></i>
                                <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 25px; height: 20px; min-width: 20px;">3</span>
                            </a>
                            <a href="#" class="btn btn-primary rounded-pill d-flex align-items-center text-white">
                                <i class="fas fa-user me-2"></i>
                                LOGIN
                            </a>

                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->

<body>
    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="container topbar bg-primary d-none d-lg-block">
            <div class="d-flex justify-content-between">
                <div class="top-info ps-2">
                    <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#"
                            class="text-white"> Location</a></small>
                    <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#"
                            class="text-white"> info@gsacommerce.com</a></small>
                    <small class="me-3"><i class="fas fa-phone me-2 text-secondary"></i> <a href="#"
                            class="text-white"> +62 813 9006 9009</a></small>
                </div>
                <div class="top-link pe-2">
                    <a class="btn btn-outline me-2 btn-md-square rounded-circle bg-white" href="">
                        <i class="fab fa-facebook-f text-dark"></i>
                    </a>
                    <a class="btn btn-outline me-2 btn-md-square rounded-circle bg-white" href="">
                        <i class="fab fa-instagram text-dark"></i>
                    </a>
                    <a class="btn btn-outline me-2 btn-md-square rounded-circle bg-white" href="">
                        <i class="fab fa-youtube text-dark"></i>
                    </a>
                    <a class="btn btn-outline me-2 btn-md-square rounded-circle bg-white" href="">
                        <i class="fab fa-twitter text-dark"></i>
                    </a>
                    <a class="btn btn-outline btn-md-square rounded-circle bg-white" href="">
                        <i class="fab fa-pinterest text-dark"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="index.html" class="navbar-brand">
                    <img src="{{ asset('storage/logo-gsa2.png') }}" alt="Logo" class="me-2"
                        style="height: 100px; width: auto;">
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="{{ url('/home')}}" class="nav-item nav-link active">Home</a>
                        <a href="{{ url('/shop') }}" class="nav-item nav-link">Shop</a>
                        <a href="{{ url('/product-detail')}}" class="nav-item nav-link">Product Detail</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="{{ url('/cart') }}" class="dropdown-item">Cart</a>
                                <a href="{{ url('/checkout') }}" class="dropdown-item">Checkout</a>
                            </div>
                        </div>
                        <a href="{{ url('contact')}}" class="nav-item nav-link">Contact</a>
                    </div>
                    <div class="d-flex m-3 me-0">
                        <!-- Tombol Search -->
                        <button
                            class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4"
                            data-bs-toggle="modal" data-bs-target="#searchModal">
                            <i class="fas fa-search text-primary"></i>
                        </button>

                        <!-- Tombol Love untuk Produk Favorit -->
                        <a href="#" class=" position-relative me-4 my-auto">
                            <i class="fas fa-heart fa-2x"></i>
                            <span
                                class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                                style="top: -5px; left: 15px; height: 20px; min-width: 20px;">2</span>
                        </a>

                        <!-- Tombol Shopping Bag -->
                        <a href="#" class="position-relative me-4 my-auto">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                            <span
                                class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                                style="top: -5px; left: 15px; height: 20px; min-width: 20px;">3</span>
                        </a>

                        <!-- Tombol User -->
                        <a href="#" class="my-auto">
                            <i class="fas fa-user fa-2x"></i>
                        </a>
                    </div>

                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


    {{-- <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords"
                            aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End --> --}}

<body class="goto-here">
    <div class="py-1 bg-primary">
    <div class="container">
        <div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
            <div class="col-lg-12 d-block">
                <div class="row d-flex">
                    <div class="col-md pr-4 d-flex topper align-items-center">
                        <div class="icon mr-2 d-flex justify-content-center align-items-center">
                            <i class="fas fa-map-pin text-white"></i>
                        </div>
                        <span class="text">Location</span>
                    </div>
                    <div class="col-md pr-4 d-flex topper align-items-center">
                        <div class="icon mr-2 d-flex justify-content-center align-items-center">
                            <i class="fas fa-phone-alt text-white"></i>
                        </div>
                        <span class="text">+62 813-9006-9009</span>
                    </div>
                    <div class="col-md pr-4 d-flex topper align-items-center">
                        <div class="icon mr-2 d-flex justify-content-center align-items-center">
                            <i class="fas fa-envelope text-white"></i>
                        </div>
                        <span class="text">info@gsacommerce.com</span>
                    </div>
                    <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
                        <span class="text">3-5 Business days delivery &amp; Free Returns</span>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <img src="{{ asset('assets/kai/assets/img/flags/id.png') }}" alt="Bahasa Indonesia">
                                <img src="{{ asset('assets/kai/assets/img/flags/england.png') }}" alt="English">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end m-0">
                            <a href="" class="dropdown-item">
                                <img src="{{ asset('assets/kai/assets/img/flags/id.png') }}" alt="Bahasa Indonesia">
                            </a>
                            <a href="" class="dropdown-item">
                                <img src="{{ asset('assets/kai/assets/img/flags/england.png') }}" alt="English">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
      </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      {{-- <a class="navbar-brand" href="index.html">Vegefoods</a> --}}
      <a href="#" class="navbar-brand"><img src="{{ asset('storage/img/logo-gsa2.png')}}" class="img-fluid" alt="" style="height: 80px; width: 100%;"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active"><a href="index.html" class="nav-link">Home</a></li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop</a>
          <div class="dropdown-menu" aria-labelledby="dropdown04">
              <a class="dropdown-item" href="{{ url('/shop')}}">Shop</a>
              <a class="dropdown-item" href="wishlist.html">Wishlist</a>
            <a class="dropdown-item" href="product-single.html">Single Product</a>
            <a class="dropdown-item" href="cart.html">Cart</a>
            <a class="dropdown-item" href="checkout.html">Checkout</a>
          </div>
        </li>
          <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
          <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
          <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
          <li class="nav-item cta cta-colored">
            <a href="cart.html" class="nav-link">
                <i class="fas fa-shopping-cart text-black"></i>
                [1]
            </a>
        </li>


        </ul>
      </div>
    </div>
  </nav>
<!-- END nav -->

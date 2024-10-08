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
    <div class="container-fluid px-5">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="index.html" class="navbar-brand brand-logo" style="padding-right: 10px;">
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
                                <li><a class="dropdown-item" href="#">Produk 1</a></li>
                                <li><a class="dropdown-item" href="#">Produk 2</a></li>
                                <li><a class="dropdown-item" href="#">Produk 3</a></li>
                            </ul>
                        </div>
                        <!-- Search Input -->
                        <input type="text" class="form-control border-0 rounded-pill px-4 py-2" placeholder="Cari Barang Impian Kamu Disini" style="flex-grow: 1; min-width: 900px;">
                        <!-- Search Button -->
                        <button class="btn  mx-2" type="submit" style="width: 40px; height: 40px;">
                            <i class="fas fa-search text-dark"></i>
                        </button>
                    </form>
                </div>
    
                <div class="d-flex m-3 me-0">
                    <a href="#" class="position-relative me-4 my-auto mx-2">
                        <i class="fa fa-shopping-bag fa-2x"></i>
                        <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">3</span>
                    </a>
                    <!-- Wishlist Icon -->
                    <a href="#" class="position-relative me-4 my-auto mx-2">
                        <i class="fas fa-heart fa-2x text-primary"></i>
                        <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">5</span>
                    </a>
                    <span class="mx-2">|</span>
    
                    <a href="#" class="d-flex align-items-center my-auto">
                        <i class="fas fa-user fa-2x me-2"></i>
                        <span class="d-none d-md-inline">Halo, Iqbal</span>
                    </a>
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


<!-- Bot Navbar Start -->
<nav class="navbar navbar-light bg-light border-top navbar-expand d-md-none d-lg-none d-xl-none fixed-bottom bottom-bar">
    <ul class="navbar-nav nav-justified w-100">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                    <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                </svg>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#searchModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
            </a>
        </li>                
        <li class="nav-item">
            <a href="#" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                </svg>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                </svg>
            </a>
        </li>
    </ul>
</nav>
<!-- Bot Navbar End -->

@extends('layouts.customer.master')

@section('content')


<!-- Carousel -->
<div id="heroCarousel" class="carousel slide position-relative mt-1" data-bs-ride="carousel">
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
            <div class="container-fluid py-5 hero-header" style="background: linear-gradient(rgba(248, 223, 173, 0.1), rgba(248, 223, 173, 0.1)), url('{{ asset('assets/default/image/carousel_default.jpg') }}'); background-position: center center; background-repeat: no-repeat; background-size: cover;">
                <div class="container py-5">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <h4 class="mb-3 text-light">Toko GSacommerce</h4>
                            <h1 class="mb-5 display-3 text-light">Your Professional Partner</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Previous -->
    <button class="carousel-control-prev prevs" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>

    <!-- Tombol Next -->
    <button class="carousel-control-next nexts" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Fruits Shop Start-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <div class="tab-class text-center">
            <div class="row g-4">
                <div class="col-lg-4 text-start">
                    <h1>Our Organic Products</h1>
                </div>
                <div class="col-lg-8 text-end">
                    <ul class="nav nav-pills d-inline-flex text-center mb-5">
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                <span class="text-dark" style="width: 130px;">All Products</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-2">
                                <span class="text-dark" style="width: 130px;">Vegetables</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-3">
                                <span class="text-dark" style="width: 130px;">Fruits</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-4">
                                <span class="text-dark" style="width: 130px;">Bread</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-5">
                                <span class="text-dark" style="width: 130px;">Meat</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s; height: 100%;">
                                        <div class="fruite-img overflow-hidden" style="height: 200px;">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 100%; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom d-flex flex-column justify-content-between" style="height: 150px;">
                                            <h4 class="text-dark text-start" style="font-size: 16px; max-height: 48px; overflow: hidden;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-3" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-4" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-5" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item shadow" style="transition: transform 0.3s, box-shadow 0.3s;">
                                        <div class="fruite-img overflow-hidden">
                                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100 rounded-top" alt="" style="transition: transform 0.3s; height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Pre Order</div>
                                        <div class="p-2 rounded-bottom">
                                            <h4 class="text-dark text-start" style="font-size: 16px;">Dck Kmy02-185 Mesin Gergaji Circular 7-1/4"</h4>
                                            <p class="text-dark text-start fs-5 fw-bold mb-3">Rp. 1.500.000</p>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <span class="text-muted small"><i class="fa fa-star text-warning me-1"></i> 0.0</span>
                                                <span class="mx-2">|</span> <!-- Garis vertikal pemisah -->
                                                <span class="text-muted small">Dibeli 7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>      
    </div>
</div>
<!-- Fruits Shop End-->

<!-- Bestsaler Product Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 700px;">
            <h1 class="display-4">Bestseller Products</h1>
            <p>Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-6 col-xl-4">
                <div class="p-4 bg-light">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100" alt="">
                        </div>
                        <div class="col-6">
                            <a href="#" class="h5">Organic Tomato</a>
                            <div class="d-flex my-3">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="mb-3">3.12 $</h4>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="p-4 rounded bg-light">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100" alt="">
                        </div>
                        <div class="col-6">
                            <a href="#" class="h5">Organic Tomato</a>
                            <div class="d-flex my-3">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="mb-3">3.12 $</h4>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="p-4 bg-light">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100" alt="">
                        </div>
                        <div class="col-6">
                            <a href="#" class="h5">Organic Tomato</a>
                            <div class="d-flex my-3">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="mb-3">3.12 $</h4>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="p-4 bg-light">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100" alt="">
                        </div>
                        <div class="col-6">
                            <a href="#" class="h5">Organic Tomato</a>
                            <div class="d-flex my-3">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="mb-3">3.12 $</h4>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="p-4 bg-light">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100" alt="">
                        </div>
                        <div class="col-6">
                            <a href="#" class="h5">Organic Tomato</a>
                            <div class="d-flex my-3">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="mb-3">3.12 $</h4>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="p-4 bg-light">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid w-100" alt="">
                        </div>
                        <div class="col-6">
                            <a href="#" class="h5">Organic Tomato</a>
                            <div class="d-flex my-3">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="mb-3">3.12 $</h4>
                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="text-center">
                    <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid rounded" alt="">
                    <div class="py-4">
                        <a href="#" class="h5">Organic Tomato</a>
                        <div class="d-flex my-3 justify-content-center">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="mb-3">3.12 $</h4>
                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="text-center">
                    <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid rounded" alt="">
                    <div class="py-4">
                        <a href="#" class="h5">Organic Tomato</a>
                        <div class="d-flex my-3 justify-content-center">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="mb-3">3.12 $</h4>
                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="text-center">
                    <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid rounded" alt="">
                    <div class="py-4">
                        <a href="#" class="h5">Organic Tomato</a>
                        <div class="d-flex my-3 justify-content-center">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="mb-3">3.12 $</h4>
                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="text-center">
                    <img src="{{ asset('assets/default/image/carousel_default.jpg') }}" class="img-fluid rounded" alt="">
                    <div class="py-2">
                        <a href="#" class="h5">Organic Tomato</a>
                        <div class="d-flex my-3 justify-content-center">
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star text-primary"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="mb-3">3.12 $</h4>
                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bestsaler Product End -->

@endsection

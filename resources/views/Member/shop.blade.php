@extends('layouts.member.master')

@section('content')
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
                        <input type="search" class="form-control p-3" placeholder="keywords"
                            aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->


    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5"
        style="position: relative; overflow: hidden; background: url('{{ asset('storage/img/page-header.jpg') }}') no-repeat center center; background-size: cover;">
        <div style="background: rgba(0, 0, 0, 0.5); position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1;">
        </div>
        <h1 class="text-center text-white display-6" style="position: relative; z-index: 2;">Produk</h1>
        <ol class="breadcrumb justify-content-center mb-0" style="position: relative; z-index: 2;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
            <li class="breadcrumb-item active text-white">Produk</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <h1 class="mb-4">Our Products</h1>
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <div class="col-xl-3">
                            <div class="input-group w-100 mx-auto d-flex">
                                <input type="search" class="form-control p-3" placeholder="Search Here"
                                    aria-describedby="search-icon-1">
                                <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-6"></div>
                        <div class="col-xl-3">
                            <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                                <label for="fruits">Default Sorting :</label>
                                <select id="fruits" name="fruitlist" class="border-0 form-select-sm bg-light me-3"
                                    form="fruitform">
                                    <option value="volvo">Nothing</option>
                                    <option value="saab">Popularity</option>
                                    <option value="opel">Organic</option>
                                    <option value="audi">Fantastic</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <ul class="list-unstyled fruite-categorie">
                                            @foreach ($categories as $category)
                                                <li>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a href="#"><i
                                                                class="fas {{ $category->icon }} me-2"></i>{{ $category->name }}</a>
                                                        <span>({{ $category->products_count }})</span>
                                                        <!-- Jika ada relasi untuk menghitung produk -->
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4 class="mb-2">Price</h4>
                                        <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput"
                                            min="0" max="500" value="0"
                                            oninput="amount.value=rangeInput.value">
                                        <output id="amount" name="amount" min-velue="0" max-value="500"
                                            for="rangeInput">0</output>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <h4 class="mb-3">Discount products</h4>
                                    <div class="d-flex align-items-center justify-content-start">
                                        <div class="rounded me-4" style="width: 100px; height: 100px;">
                                            <img src="{{ asset('storage/img/machine.jpg') }}" class="img-fluid rounded"
                                                alt="">
                                        </div>
                                        <div>
                                            <h6 class="mb-2">Electrician Scissor</h6>
                                            <div class="d-flex mb-2">
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="d-flex mb-2">
                                                <h5 class="fw-bold me-2">Rp 66k</h5>
                                                <h5 class="text-danger text-decoration-line-through">Rp 99k</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-start">
                                        <div class="rounded me-4" style="width: 100px; height: 100px;">
                                            <img src="{{ asset('storage/img/machine.jpg') }}" class="img-fluid rounded"
                                                alt="">
                                        </div>
                                        <div>
                                            <h6 class="mb-2">Electrician Scissor</h6>
                                            <div class="d-flex mb-2">
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="d-flex mb-2">
                                                <h5 class="fw-bold me-2">Rp 66k</h5>
                                                <h5 class="text-danger text-decoration-line-through">Rp 99k</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-start">
                                        <div class="rounded me-4" style="width: 100px; height: 100px;">
                                            <img src="{{ asset('storage/img/machine.jpg') }}" class="img-fluid rounded"
                                                alt="">
                                        </div>
                                        <div>
                                            <h6 class="mb-2">Electrician Scissor</h6>
                                            <div class="d-flex mb-2">
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star text-secondary"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="d-flex mb-2">
                                                <h5 class="fw-bold me-2">Rp 66k</h5>
                                                <h5 class="text-danger text-decoration-line-through">Rp 99k</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center my-4">
                                        <a href="#"
                                            class="btn border border-secondary px-4 py-3 rounded-pill text-primary w-100">More
                                            Discount</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-4 justify-content-center">
                                @foreach ($products as $product)
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <a href="{{ url('product-detail') }}" class="text-decoration-none">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="{{ asset($product->image) }}"
                                                        class="img-fluid w-100 rounded-top" alt="{{ $product->name }}">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                    style="top: 10px; left: 10px;">
                                                    {{ $product->category_name }}
                                                </div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h5>{{ $product->name }}</h5>
                                                    <p>{{ $product->description }}</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">Rp
                                                            {{ number_format($product->price, 0, ',', '.') }}</p>
                                                        <a href="#"
                                                            class="btn border border-secondary rounded-pill px-3 text-primary">
                                                            <i class="fa fa-shopping-cart me-2 text-primary"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach

                                <div class="col-12">
                                    <div class="pagination d-flex justify-content-center mt-5">
                                        <a href="#" class="rounded">&laquo;</a>
                                        <a href="#" class="active rounded">1</a>
                                        <a href="#" class="rounded">2</a>
                                        <a href="#" class="rounded">3</a>
                                        <a href="#" class="rounded">4</a>
                                        <a href="#" class="rounded">5</a>
                                        <a href="#" class="rounded">6</a>
                                        <a href="#" class="rounded">&raquo;</a>
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
@endsection

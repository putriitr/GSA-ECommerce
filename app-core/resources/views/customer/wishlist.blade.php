@extends('layouts.customer.master')

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
        <h1 class="text-center text-white display-6" style="position: relative; z-index: 2;">Wishlist</h1>
        <ol class="breadcrumb justify-content-center mb-0" style="position: relative; z-index: 2;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
            <li class="breadcrumb-item active text-white">Wishlist</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <div class="container-fluid py-5">
        <div class="container py-5">

            <section class="ftco-section ftco-cart">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 ftco-animate">
                            <div class="cart-list">
                                <table class="table">
                                    <thead class="thead-primary">
                                        <tr class="text-center">
                                            <th>&nbsp;</th>
                                            <th>Product List</th>
                                            <th>&nbsp;</th>
                                            <th class="price">Price</th>
                                            <th>&nbsp;</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-left">
                                            <td class="product-remove"><a href="#"><span class="ion-ios-close"></span></a></td>
                                            <td class="image-prod">
                                                <img src="{{ asset('storage/img/machine.jpg') }}" alt="Machine Image" style="width: 100px; height: 80px; object-fit: cover;">
                                            </td>
                                            <td class="product-name">
                                                <h3>Bell Pepper</h3>
                                                <p>Far far away, behind the word mountains, far from the countries</p>
                                            </td>
                                            <td class="price">Rp 66.000</td> <!-- Kolom harga -->
                                            <td>&nbsp;</td> <!-- Kolom kosong sebelum aksi -->
                                            <td>
                                                <button class="btn btn-md rounded-circle bg-light border mt-4">
                                                    <i class="fa fa-times text-danger"></i> <!-- Tombol hapus hanya di sini -->
                                                </button>
                                            </td>
                                        </tr><!-- END TR -->

                                        <tr class="text-left">
                                            <td class="product-remove"><a href="#"><span class="ion-ios-close"></span></a></td>
                                            <td class="image-prod">
                                                <img src="{{ asset('storage/img/machine.jpg') }}" alt="Machine Image" style="width: 100px; height: 80px; object-fit: cover;">
                                            </td>
                                            <td class="product-name">
                                                <h3>Bell Pepper</h3>
                                                <p>Far far away, behind the word mountains, far from the countries</p>
                                            </td>
                                            <td class="price">Rp 66.000</td> <!-- Kolom harga -->
                                            <td>&nbsp;</td> <!-- Kolom kosong sebelum aksi -->
                                            <td>
                                                <button class="btn btn-md rounded-circle bg-light border mt-4">
                                                    <i class="fa fa-times text-danger"></i> <!-- Tombol hapus hanya di sini -->
                                                </button>
                                            </td>
                                        </tr><!-- END TR -->

                                        <tr class="text-left">
                                            <td class="product-remove"><a href="#"><span class="ion-ios-close"></span></a></td>
                                            <td class="image-prod">
                                                <img src="{{ asset('storage/img/machine.jpg') }}" alt="Machine Image" style="width: 100px; height: 80px; object-fit: cover;">
                                            </td>
                                            <td class="product-name">
                                                <h3>Bell Pepper</h3>
                                                <p>Far far away, behind the word mountains, far from the countries</p>
                                            </td>
                                            <td class="price">Rp 66.000</td> <!-- Kolom harga -->
                                            <td>&nbsp;</td> <!-- Kolom kosong sebelum aksi -->
                                            <td>
                                                <button class="btn btn-md rounded-circle bg-light border mt-4">
                                                    <i class="fa fa-times text-danger"></i> <!-- Tombol hapus hanya di sini -->
                                                </button>
                                            </td>
                                        </tr><!-- END TR -->

                                        <tr class="text-left">
                                            <td class="product-remove"><a href="#"><span class="ion-ios-close"></span></a></td>
                                            <td class="image-prod">
                                                <img src="{{ asset('storage/img/machine.jpg') }}" alt="Machine Image" style="width: 100px; height: 80px; object-fit: cover;">
                                            </td>
                                            <td class="product-name">
                                                <h3>Bell Pepper</h3>
                                                <p>Far far away, behind the word mountains, far from the countries</p>
                                            </td>
                                            <td class="price">Rp 66.000</td> <!-- Kolom harga -->
                                            <td>&nbsp;</td> <!-- Kolom kosong sebelum aksi -->
                                            <td>
                                                <button class="btn btn-md rounded-circle bg-light border mt-4">
                                                    <i class="fa fa-times text-danger"></i> <!-- Tombol hapus hanya di sini -->
                                                </button>
                                            </td>
                                        </tr><!-- END TR -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

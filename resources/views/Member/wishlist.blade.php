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
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Wishlist</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
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
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-left">
                                            <td class="product-remove"><a href="#"><span
                                                        class="ion-ios-close"></span></a></td>

                                            <td class="image-prod">
                                                <img src="{{ asset('storage/img/machine.jpg') }}" alt="Machine Image"
                                                    style="width: 100px; height: 80px; object-fit: cover;">
                                            </td>

                                            <td class="product-name">
                                                <h3>Bell Pepper</h3>
                                                <p>Far far away, behind the word mountains, far from the countries</p>
                                            </td>

                                            <td class="price">$4.90</td>

                                            <td class="quantity">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="quantity"
                                                        class="quantity form-control input-number" value="1"
                                                        min="1" max="100">
                                                </div>
                                            </td>

                                            <td class="total">$4.90</td>
                                        </tr><!-- END TR-->

                                        <tr class="text-left">
                                            <td class="product-remove"><a href="#"><span
                                                        class="ion-ios-close"></span></a></td>

                                            <td class="image-prod">
                                                <img src="{{ asset('storage/img/machine.jpg') }}" alt="Machine Image"
                                                    style="width: 100px; height: 80px; object-fit: cover;">
                                            </td>

                                            <td class="product-name">
                                                <h3>Bell Pepper</h3>
                                                <p>Far far away, behind the word mountains, far from the countries</p>
                                            </td>

                                            <td class="price">$15.70</td>

                                            <td class="quantity">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="quantity"
                                                        class="quantity form-control input-number" value="1"
                                                        min="1" max="100">
                                                </div>
                                            </td>

                                            <td class="total">$15.70</td>
                                        </tr><!-- END TR-->

                                        <tr class="text-left">
                                            <td class="product-remove"><a href="#"><span
                                                        class="ion-ios-close"></span></a></td>

                                            <td class="image-prod">
                                                <img src="{{ asset('storage/img/machine.jpg') }}" alt="Machine Image"
                                                    style="width: 100px; height: 80px; object-fit: cover;">
                                            </td>

                                            <td class="product-name">
                                                <h3>Bell Pepper</h3>
                                                <p>Far far away, behind the word mountains, far from the countries</p>
                                            </td>

                                            <td class="price">$15.70</td>

                                            <td class="quantity">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="quantity"
                                                        class="quantity form-control input-number" value="1"
                                                        min="1" max="100">
                                                </div>
                                            </td>

                                            <td class="total">$15.70</td>
                                        </tr><!-- END TR-->

                                        <tr class="text-left">
                                            <td class="product-remove"><a href="#"><span
                                                        class="ion-ios-close"></span></a></td>

                                            <td class="image-prod">
                                                <img src="{{ asset('storage/img/machine.jpg') }}" alt="Machine Image"
                                                    style="width: 100px; height: 80px; object-fit: cover;">
                                            </td>

                                            <td class="product-name">
                                                <h3>Bell Pepper</h3>
                                                <p>Far far away, behind the word mountains, far from the countries</p>
                                            </td>

                                            <td class="price">$15.70</td>

                                            <td class="quantity">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="quantity"
                                                        class="quantity form-control input-number" value="1"
                                                        min="1" max="100">
                                                </div>
                                            </td>

                                            <td class="total">$15.70</td>
                                        </tr><!-- END TR-->

                                        <tr class="text-left">
                                            <td class="product-remove"><a href="#"><span
                                                        class="ion-ios-close"></span></a></td>

                                            <td class="image-prod">
                                                <img src="{{ asset('storage/img/machine.jpg') }}" alt="Machine Image"
                                                    style="width: 100px; height: 80px; object-fit: cover;">
                                            </td>

                                            <td class="product-name">
                                                <h3>Bell Pepper</h3>
                                                <p>Far far away, behind the word mountains, far from the countries</p>
                                            </td>

                                            <td class="price">$15.70</td>

                                            <td class="quantity">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="quantity"
                                                        class="quantity form-control input-number" value="1"
                                                        min="1" max="100">
                                                </div>
                                            </td>

                                            <td class="total">$15.70</td>
                                        </tr><!-- END TR-->

                                        <tr class="text-left">
                                            <td class="product-remove"><a href="#"><span
                                                        class="ion-ios-close"></span></a></td>

                                            <td class="image-prod">
                                                <img src="{{ asset('storage/img/machine.jpg') }}" alt="Machine Image"
                                                    style="width: 100px; height: 80px; object-fit: cover;">
                                            </td>

                                            <td class="product-name">
                                                <h3>Bell Pepper</h3>
                                                <p>Far far away, behind the word mountains, far from the countries</p>
                                            </td>

                                            <td class="price">$15.70</td>

                                            <td class="quantity">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="quantity"
                                                        class="quantity form-control input-number" value="1"
                                                        min="1" max="100">
                                                </div>
                                            </td>

                                            <td class="total">$15.70</td>
                                        </tr><!-- END TR-->
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

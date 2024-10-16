@extends('layouts.customer.master')

@section('content')
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
                                <table class="table text-center">
                                    <thead class="thead-primary bg-light">
                                        <tr>
                                            <th style="width: 20%">Product Image</th>
                                            <th style="width: 40%">Product Details</th>
                                            <th style="width: 20%">Price</th>
                                            <th style="width: 20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($wishlistItems as $item)
                                            <tr>
                                                <!-- Product Image -->
                                                <td class="align-middle">
                                                    <img src="{{ $item->product->images->isNotEmpty() ? asset($item->product->images->first()->image) : asset('storage/img/default.png') }}" 
                                                         alt="{{ $item->product->name }}" 
                                                         style="width: 100px; height: 80px; object-fit: cover;">
                                                </td>
                                                
                                                <!-- Product Name & Description -->
                                                <td class="align-middle text-left">
                                                    <h5 class="mb-1">
                                                        <a href="{{ route('customer.product.show', $item->product->slug) }}" class="text-dark text-decoration-none">
                                                            {{ $item->product->name }}
                                                        </a>
                                                    </h5>
                                                </td>

                                                <!-- Product Price -->
                                                <td class="align-middle">
                                                    <span class="text-dark fw-bold">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                                </td>

                                                <!-- Actions -->
                                                <td class="align-middle">
                                                    <!-- Remove from Wishlist -->
                                                    <form action="{{ route('wishlist.remove', $item->product->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button class="btn btn-danger btn-sm rounded-circle" type="submit">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>

                                                    <!-- Move to Cart -->
                                                    <form action="{{ route('wishlist.moveToCart', $item->product->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button class="btn btn-success btn-sm rounded-circle" type="submit">
                                                            <i class="fa fa-shopping-cart"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Your wishlist is empty.</td>
                                            </tr>
                                        @endforelse
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

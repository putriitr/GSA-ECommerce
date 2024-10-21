@extends('layouts.admin.master')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

    @if(session('admin_login'))
    <div id="floating-notification-welcome-back" class="alert alert-info alert-dismissible fade show position-fixed d-flex align-items-center" role="alert" style="bottom: 20px; right: 20px; z-index: 1050; min-width: 320px; max-width: 420px; padding: 20px;">
        <i class="fas fa-smile me-3" style="font-size: 24px;"></i>
        <span>{{ session('admin_login') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="row">
                        <!-- Quick Access Cards -->
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card text-center shadow-lg border-0 rounded-lg h-100 hover-card">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div class="icon-box mb-3">
                                        <i class="bx bx-package bx-lg text-primary"></i>
                                    </div>
                                    <h5 class="card-title">Manage Products</h5>
                                    <p class="card-text">Access the list of products and manage them.</p>
                                    <a href="{{ route('product.index') }}" class="btn btn-primary mt-auto">Go to Products</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card text-center shadow-lg border-0 rounded-lg h-100 hover-card">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div class="icon-box mb-3">
                                        <i class="bx bx-cart bx-lg text-success"></i>
                                    </div>
                                    <h5 class="card-title">Manage Orders</h5>
                                    <p class="card-text">View and manage customer orders.</p>
                                    <a href="{{ route('admin.orders.index') }}" class="btn btn-success mt-auto">Go to Orders</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card text-center shadow-lg border-0 rounded-lg h-100 hover-card">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div class="icon-box mb-3">
                                        <i class="bx bx-credit-card bx-lg text-danger"></i>
                                    </div>
                                    <h5 class="card-title">Manage Payments</h5>
                                    <p class="card-text">Monitor and process payments.</p>
                                    <a href="{{ route('admin.payments.index') }}" class="btn btn-danger mt-auto">Go to Payments</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card text-center shadow-lg border-0 rounded-lg h-100 hover-card">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div class="icon-box mb-3">
                                        <i class="bx bx-cog bx-lg text-info"></i>
                                    </div>
                                    <h5 class="card-title">Manage Parameters</h5>
                                    <p class="card-text">Configure system parameters and settings.</p>
                                    <a href="{{ route('masterdata.parameters.index') }}" class="btn btn-info mt-auto">Go to Parameters</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card text-center shadow-lg border-0 rounded-lg h-100 hover-card">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div class="icon-box mb-3">
                                        <i class="bx bx-image bx-lg text-warning"></i>
                                    </div>
                                    <h5 class="card-title">Manage Home Banners</h5>
                                    <p class="card-text">Add or update banners displayed on the homepage.</p>
                                    <a href="{{ route('admin.banner-home.banners.index') }}" class="btn btn-warning mt-auto">Go to Home Banners</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card text-center shadow-lg border-0 rounded-lg h-100 hover-card">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <div class="icon-box mb-3">
                                        <i class="bx bx-layer bx-lg text-secondary"></i>
                                    </div>
                                    <h5 class="card-title">Manage Micro Banners</h5>
                                    <p class="card-text">Add or update banners displayed on specific sections.</p>
                                    <a href="{{ route('admin.banner-micro.banners.index') }}" class="btn btn-secondary mt-auto">Go to Micro Banners</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 col-lg-6 order-2 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Transactions</h5>
                        </div>
                        <div class="card-body">
                            <ul class="p-0 m-0">
                                @foreach($payments as $payment)
                                    <li class="d-flex mb-4 pb-1">
                                        <!-- Wrap the payment details inside an <a> tag pointing to the show payment route -->
                                        <a href="{{ route('admin.payments.index') }}" class="d-flex w-100 text-decoration-none">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <img src="{{ asset('assets/default/image/user.png') }}" alt="Payment" class="rounded" />
                                            </div>
                                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <small class="text-muted d-block">Payment ID: {{ $payment->id }}</small>
                                                    <small class="text-muted d-block">Invoice: {{ $payment->order->invoice_number }}</small>
                                                    <small class="text-muted d-block">Customer: {{ optional($payment->order->user)->name ?? 'N/A' }}</small>
                                                </div>
                                                <div class="user-progress d-flex align-items-center gap-1">
                                                    @if($payment->status === 'completed')
                                                        @if($order->status === 'cancelled' || $order->status === 'cancelled_by_system')
                                                            <h6 class="mb-0 text-muted">Cancelled</h6>
                                                        @else
                                                            <h6 class="mb-0 text-success">+{{ 'Rp' . number_format($payment->amount, 0, ',', '.') }}</h6>
                                                        @endif
                                                    @else
                                                        <h6 class="mb-0 text-danger">{{ ucfirst($payment->status) }}</h6>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="pagination justify-content-center">
                                {{ $payments->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-md-6 col-lg-6 order-2 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Orders</h5>
                        </div>
                        <div class="card-body">
                            <ul class="p-0 m-0">
                                @foreach($orders as $order)
                                    <li class="d-flex mb-4 pb-1">
                                        <!-- Wrap the entire order inside an <a> tag pointing to the show order route -->
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="d-flex w-100 text-decoration-none">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <img src="{{ asset('assets/default/image/user.png') }}" alt="Order" class="rounded" />
                                            </div>
                                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <small class="text-muted d-block mb-1">Order #{{ $order->id }}</small>
                                                    <h6 class="mb-0">Status: {{ ucfirst($order->status) }}</h6>
                                                    <p class="mb-0">Customer: {{ $order->user->name ?? 'N/A' }}</p>
                                                </div>
                                                <div class="user-progress d-flex align-items-center gap-1">
                                                    @if($order->status === 'cancelled' || $order->status === 'cancelled_by_system')
                                                        <h6 class="mb-0 text-muted">Cancelled</h6>
                                                    @else
                                                        <h6 class="mb-0 text-success">+{{ 'Rp' . number_format($order->total, 0, ',', '.') }}</h6>
                                                    @endif
                                                    <span class="text-muted">Rp</span>
                                                </div>                                            
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="pagination justify-content-center">
                                {{ $orders->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>

    <style>
        .hover-card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease-in-out;
        }
        .icon-box {
            font-size: 2.5rem;
        }

        .card-body ul li a {
        transition: background-color 0.3s ease;
    }

    .card-body ul li a:hover {
        background-color: #f1f1f1; /* Light grey background on hover */
        border-radius: 5px;
    }

    /* Hover effect for text color */
    .card-body ul li a:hover .text-muted,
    .card-body ul li a:hover h6,
    .card-body ul li a:hover p {
        color: #333; /* Darker text color on hover */
    }
    </style>
@endsection





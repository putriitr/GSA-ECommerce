@extends('layouts.customer.master')

@section('content')

@php
    use App\Models\Order;
@endphp


<div class="container-fluid py-5 mt-5">
    <div class="container py-5 mt-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                @include('customer.settings.partials.sidebar')            
            </div>

            <!-- Main Content -->
            <div class="col-md-9 mt-2">

                <!-- Notifications -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <h2 class="mb-4">Daftar Pesanan</h2>

                <!-- Status Filter Buttons -->
                <div class="mb-4 d-flex align-items-center flex-wrap">
                    <!-- Adjust these links to pass the status as a parameter in the URL -->
                    <a href="{{ route('customer.orders.index', ['status' => 'semua']) }}" class="btn {{ $status == 'semua' ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill me-2 mb-2">Semua</a>
                    
                    <a href="{{ route('customer.orders.index', ['status' => Order::STATUS_WAITING_APPROVAL]) }}" class="btn {{ $status == Order::STATUS_WAITING_APPROVAL ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill me-2 mb-2">Menunggu Konfirmasi</a>
                    
                    <a href="{{ route('customer.orders.index', ['status' => Order::STATUS_APPROVED]) }}" class="btn {{ $status == Order::STATUS_APPROVED ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill me-2 mb-2">Disetujui</a>
                    
                    <a href="{{ route('customer.orders.index', ['status' => Order::STATUS_PENDING_PAYMENT]) }}" class="btn {{ $status == Order::STATUS_PENDING_PAYMENT ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill me-2 mb-2 position-relative">Menunggu Pembayaran
                        @if($waitingForPaymentCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $waitingForPaymentCount }}
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        @endif
                    </a>
                    
                    <a href="{{ route('customer.orders.index', ['status' => Order::STATUS_PROCESSING]) }}" class="btn {{ $status == Order::STATUS_PROCESSING ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill me-2 mb-2">Diproses</a>
                    
                    <a href="{{ route('customer.orders.index', ['status' => Order::STATUS_SHIPPED]) }}" class="btn {{ $status == Order::STATUS_SHIPPED ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill me-2 mb-2">Dikirim</a>
                    
                    <a href="{{ route('customer.orders.index', ['status' => Order::STATUS_DELIVERED]) }}" class="btn {{ $status == Order::STATUS_DELIVERED ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill me-2 mb-2">Tiba di Tujuan</a>
                    
                    <a href="{{ route('customer.orders.index', ['status' => Order::STATUS_CANCELLED]) }}" class="btn {{ $status == Order::STATUS_CANCELLED ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill me-2 mb-2">Dibatalkan</a>
                    
                    <a href="{{ route('customer.orders.index', ['status' => Order::STATUS_CANCELLED_BY_ADMIN]) }}" class="btn {{ $status == Order::STATUS_CANCELLED_BY_ADMIN ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill me-2 mb-2">Dibatalkan oleh Admin</a>
                    
                    <a href="{{ route('customer.orders.index', ['status' => Order::STATUS_CANCELLED_BY_SYSTEM]) }}" class="btn {{ $status == Order::STATUS_CANCELLED_BY_SYSTEM ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill me-2 mb-2">Dibatalkan oleh Sistem</a>

                    <a href="{{ route('customer.orders.index', ['status' => '']) }}" class="text-success ms-auto mt-2">Reset Filter</a>
                </div>
                

                <!-- Order List -->
                @if($orders->isEmpty())
                    <p>No orders found for this status.</p>
                @else
                    @foreach($orders as $order)
                    <div class="card mb-4 shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <!-- Order Info -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <p class="mb-0 text-muted">Belanja {{ $order->created_at->format('d M Y') }}</p>
                                    <span class="badge 
                                        @switch($order->status)
                                            @case(Order::STATUS_WAITING_APPROVAL) bg-warning @break
                                            @case(Order::STATUS_APPROVED) bg-info @break
                                            @case(Order::STATUS_PENDING_PAYMENT) bg-warning @break
                                            @case(Order::STATUS_CONFIRMED) bg-success @break
                                            @case(Order::STATUS_PROCESSING) bg-primary @break
                                            @case(Order::STATUS_SHIPPED) bg-secondary @break
                                            @case(Order::STATUS_DELIVERED) bg-success @break
                                            @case(Order::STATUS_CANCELLED)
                                            @case(Order::STATUS_CANCELLED_BY_ADMIN)
                                            @case(Order::STATUS_CANCELLED_BY_SYSTEM) bg-danger @break
                                            @default bg-light
                                        @endswitch
                                    ">
                                        @switch($order->status)
                                            @case(Order::STATUS_WAITING_APPROVAL)
                                                Menunggu Konfirmasi
                                                @break
                                            @case(Order::STATUS_APPROVED)
                                                Menunggu Pembayaran
                                                @break
                                            @case(Order::STATUS_PENDING_PAYMENT)
                                                Menunggu Pembayaran Anda
                                                @break
                                            @case(Order::STATUS_CONFIRMED)
                                                Pembayaran Diterima
                                                @break
                                            @case(Order::STATUS_PROCESSING)
                                                Diproses
                                                @break
                                            @case(Order::STATUS_SHIPPED)
                                                Dikirim
                                                @break
                                            @case(Order::STATUS_DELIVERED)
                                                Tiba di Tujuan
                                                @break
                                            @case(Order::STATUS_CANCELLED)
                                            @case(Order::STATUS_CANCELLED_BY_ADMIN)
                                            @case(Order::STATUS_CANCELLED_BY_SYSTEM)
                                                Dibatalkan
                                                @break
                                            @default
                                                {{ ucfirst($order->status) }}
                                        @endswitch
                                    </span>
                                    <small class="text-muted d-block">INV/{{ $order->invoice_number }}</small>
                                </div>                              
                                <div class="text-end">
                                    <p class="mb-0"><strong>Total Belanja</strong></p>
                                    <p class="mb-0">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="d-flex align-items-center mt-3">
                                <img src="{{ asset($order->items->first()->product->images->first()->image) }}" alt="{{ $order->items->first()->product->name }}" class="img-fluid rounded me-3" style="width: 80px; height: 80px;">
                                <div>
                                    <p class="mb-0"><strong>{{ $order->items->first()->product->name }}</strong></p>
                                    <small>{{ $order->items->first()->quantity }} barang x Rp{{ number_format($order->items->first()->price, 0, ',', '.') }}</small>
                                </div>
                            </div>

                            <!-- Transaction Links -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('customer.order.show', $order->id) }}" class="text-success">Lihat Detail Transaksi</a>
                                <div class="dropdown">
                                    <button class="btn btn-light border dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        ...
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Help</a></li>
                                        
                                        @if($order->status === 'pending')
                                            <li><a class="dropdown-item" href="#">Cancel Order</a></li>
                                        @elseif($order->status === 'approved')
                                            <li><a class="dropdown-item" href="{{ route('customer.order.show', $order->id) }}">Bayar Pembayaran Anda</a></li>
                                        @elseif($order->status === 'shipped')
                                            <li>
                                                <form action="{{ route('customer.complete.order', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="dropdown-item">Diterima</button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</div>

<!-- Custom Styles to Match the Design -->
<style>
    /* Filter Buttons */
    .btn-outline-success, .btn-outline-secondary {
        border: 1px solid #ced4da;
        padding: 10px 20px;
        border-radius: 50px;
    }

    /* Card Customization */
    .card {
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Dropdown Button */
    .dropdown-toggle {
        padding: 0.5rem;
    }

    /* Badge and Info */
    .badge.bg-danger {
        background-color: #ff6b6b !important;
        font-size: 0.8rem;
    }

    /* Small Links */
    a.text-success {
        font-size: 0.9rem;
    }

    /* Responsive Adjustment */
    @media (max-width: 768px) {
        .btn-outline-success, .btn-outline-secondary {
            font-size: 0.9rem;
        }
        .card-body p, .card-body small {
            font-size: 0.85rem;
        }
    }

    /* Badge Customization */
.badge.bg-danger {
    background-color: #ff6b6b !important;
    font-size: 0.7rem;
    padding: 0.3rem 0.5rem;
}

</style>

@endsection

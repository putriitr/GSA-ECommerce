@extends('layouts.admin.master')

@section('content')
<div class="container py-5">
    <!-- Title and Action Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Order Details - Order ID: {{ $order->id }}</h1>

        <!-- Actions for the Admin -->
        @if($order->status === 'pending')
            <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success btn-sm">Approve Order</button>
            </form>
        @endif

        @if($order->status === 'payment_verified')
            <form action="{{ route('admin.mark.packing', $order->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-warning btn-sm">Mark as Packing</button>
            </form>
        @endif

        @if($order->status === 'packing')
            <!-- Button to trigger shipping modal -->
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#shippingModal">
                Mark as Shipped
            </button>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Order Information Section -->
    <div class="card mb-4">
        <div class="card-header">
            Order Information
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <th>Customer Name</th>
                    <td>{{ $order->user->full_name }}</td>
                </tr>
                <tr>
                    <th>Total Amount</th>
                    <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst($order->status) }}</td>
                </tr>
                <tr>
                    <th>Negotiated</th>
                    <td>{{ $order->is_negotiated ? 'Yes' : 'No' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Order Items Section -->
    <div class="card mb-4">
        <div class="card-header">
            Order Items
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Customer Address Section (Only visible when status is 'packing') -->
    @if($order->status === 'packing')
    <div class="card mb-4">
        <div class="card-header">
            Customer Address
        </div>
        <div class="card-body">
            @if($order->user)
                @php
                    $activeAddress = $order->user->addresses->where('is_active', 1)->first();
                @endphp

                @if($activeAddress)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Label Alamat</strong></td>
                                <td>{{ $activeAddress->label_alamat }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Penerima</strong></td>
                                <td>{{ $activeAddress->nama_penerima }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nomor Telepon</strong></td>
                                <td>{{ $activeAddress->nomor_telepon }}</td>
                            </tr>
                            <tr>
                                <td><strong>Provinsi</strong></td>
                                <td>{{ $activeAddress->provinsi }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kota/Kabupaten</strong></td>
                                <td>{{ $activeAddress->kota_kabupaten }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kodepos</strong></td>
                                <td>{{ $activeAddress->kodepos }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kecamatan</strong></td>
                                <td>{{ $activeAddress->kecamatan }}</td>
                            </tr>
                            <tr>
                                <td><strong>Detail Alamat</strong></td>
                                <td>{{ $activeAddress->detail_alamat }}</td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <p>No active address found for this customer.</p>
                @endif
            @else
                <p>Customer information is missing for this order.</p>
            @endif
        </div>
    </div>
    @endif

    <!-- Shipping Modal -->
    <div class="modal fade" id="shippingModal" tabindex="-1" aria-labelledby="shippingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shippingModalLabel">Mark Order as Shipped</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.orders.shipped', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Tracking Number Input -->
                        <div class="mb-3">
                            <label for="tracking_number" class="form-label">Tracking Number</label>
                            <input type="text" class="form-control" name="tracking_number" required>
                        </div>

                        <!-- Shipping Service Dropdown -->
                        <div class="mb-3">
                            <label for="shipping_service_id" class="form-label">Shipping Service</label>
                            <select class="form-select" name="shipping_service_id" required>
                                <option value="" disabled selected>Select a shipping service</option>
                                @foreach($shipping as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Mark as Shipped</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

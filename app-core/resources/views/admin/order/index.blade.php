@extends('layouts.admin.master')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Manage Orders</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Orders Section -->
    <h2 class="mb-4">Orders</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Negotiated</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->full_name }}</td>
                <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ $order->is_negotiated ? 'Yes' : 'No' }}</td>
                <td>
                    @if($order->is_negotiated)
                        @if($order->status === 'negotiation')
                            <!-- Show negotiation handling options -->
                            <form action="{{ route('admin.orders.handleNegotiation', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="d-flex align-items-center">
                                    <input type="number" name="negotiated_price" class="form-control me-2" placeholder="Negotiated Price" required>
                                    <button type="submit" name="accept_negotiation" value="1" class="btn btn-success btn-sm">Accept</button>
                                    <button type="submit" name="accept_negotiation" value="0" class="btn btn-danger btn-sm ms-2">Reject</button>
                                </div>
                            </form>
                        @elseif($order->status === 'negotiation_approved')
                            <!-- After negotiation is approved, show regular order actions -->
                            <form action="{{ route('admin.mark.packing', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning">Mark as Packing</button>
                            </form>
                        @endif
                    @else
                        @if($order->status === 'pending')
                            <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-sm">Approve Order</button>
                            </form>
                        @endif

                        @if($order->status === 'payment_verified')
                        <form action="{{ route('admin.mark.packing', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-warning">Mark as Packing</button>
                        </form>
                        @endif

                        @if($order->status === 'packing')
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#shipOrderModal-{{ $order->id }}">Mark as Shipped</button>
                        @endif
                    @endif

                    <!-- Modal for Adding Tracking Number and Marking Order as Shipped -->
                    <div class="modal fade" id="shipOrderModal-{{ $order->id }}" tabindex="-1" aria-labelledby="shipOrderModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="shipOrderModalLabel">Mark as Shipped</h5>
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

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

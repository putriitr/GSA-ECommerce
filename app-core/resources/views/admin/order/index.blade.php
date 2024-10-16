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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ optional($order->user)->full_name ?? optional($order->user)->name }}</td>
                <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                <td>
                    {{ ucfirst($order->status) }}
                    @if (!$order->is_viewed)
                        <span class="badge bg-danger ms-2">New</span>
                    @endif
                </td>
                <td>
                    <!-- Show Order Details -->
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm">View Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

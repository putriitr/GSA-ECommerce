@extends('layouts.customer.master')

@section('content')
<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <!-- Order Details -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="fw-bold">Order Details (Order #{{ $order->id }})</h4>
                        <p>Status: 
                            @if ($order->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif ($order->status == 'approved')
                                <span class="badge bg-info">Approved</span>
                            @elseif ($order->status == 'shipped')
                                <span class="badge bg-primary">Shipped</span>
                            @elseif ($order->status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                            @endif
                        </p>
                        <p>Total Amount: <strong>Rp{{ number_format($order->total, 0, ',', '.') }}</strong></p>
                        
                        <!-- Order Items -->
                        <h5 class="fw-bold mt-4">Items</h5>
                        <table class="table">
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

                        <!-- Cancel Order if Pending -->
                        @if($order->status === 'pending')
                            <form action="{{ route('customer.order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger">Cancel Order</button>
                            </form>
                        @endif

                        <!-- Mark as Completed if Shipped -->
                        @if($order->status === 'shipped')
                            <form action="{{ route('customer.complete.order', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Mark as Completed</button>
                            </form>
                        @endif

                        <!-- Payment Proof Submission -->
                        @if($order->status == 'approved')
                        <div class="mt-4">
                            <h5 class="fw-bold">Submit Payment Proof</h5>
                            <form action="{{ route('customer.payment.submit', $order->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="payment_proof" class="form-label">Upload Payment Proof</label>
                                    <input type="file" class="form-control" name="payment_proof" required>
                                </div>
                                <button type="submit" class="btn btn-success">Submit Payment</button>
                            </form>
                        </div>
                        @endif

                        <!-- Display Payment Proof -->
                        @if($order->payments->isNotEmpty())
                        <div class="mt-4">
                            <h5 class="fw-bold">Payment Details</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Payment Proof</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->payments as $payment)
                                    <tr>
                                        <td>
                                            <a href="{{ asset($payment->payment_proof) }}" target="_blank" class="btn btn-sm btn-primary">View Proof</a>
                                        </td>
                                        <td>
                                            <span class="badge {{ $payment->status == 'verified' ? 'bg-success' : 'bg-warning' }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        <!-- Shipping Information -->
                        @if($order->status == 'shipped')
                            <div class="mt-4">
                                <h5 class="fw-bold">Shipping Information</h5>
                                <p>Shipping Service: <strong>{{ $order->shippingService->name ?? 'Not specified' }}</strong></p> <!-- Show shipping service name -->
                                <p>Tracking Number: <strong>{{ $order->tracking_number }}</strong></p>
                            </div>
                        @endif


                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

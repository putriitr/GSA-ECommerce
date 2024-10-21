@extends('layouts.customer.master')

@section('content')
<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <!-- Order Details -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="fw-bold">Order Details (#{{ $order->id }})</h4>
                            @if(in_array($order->status, ['approved', 'packing', 'shipped', 'completed']))
                                <a href="{{ route('customer.order.invoice', $order->id) }}" class="btn btn-primary">Download Invoice</a>
                            @endif
                        </div>
                        <p class="fw-bold">Invoice Number: {{ $order->invoice_number }}</p>
                        <p>Status: 
                            @if ($order->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif ($order->status == 'approved')
                                <span class="badge bg-info">Approved</span>
                            @elseif ($order->status == 'shipped')
                                <span class="badge bg-primary">Shipped</span>
                            @elseif ($order->status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif ($order->status == 'cancelled')
                                <span class="badge bg-warning">Cancelled</span>
                            @elseif ($order->status == 'cancelled_by_system')
                                <span class="badge bg-danger">Cancelled By System</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                            @endif
                        </p>

                        <!-- Display timestamps for status changes -->
                        <div class="mt-3">
                            <h6 class="fw-bold">Status History:</h6>
                            <ul class="list-unstyled">
                                @if($order->created_at)
                                    <li>Order Placed: <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong></li>
                                @endif
                                @if($order->approved_at)
                                    <li>Approved: <strong>{{ $order->approved_at->format('d M Y, H:i') }}</strong></li>
                                @endif
                                @if($order->payment_verified_at)
                                    <li>Payment Verified: <strong>{{ $order->payment_verified_at->format('d M Y, H:i') }}</strong></li>
                                @endif
                                @if($order->packing_at)
                                    <li>Packing: <strong>{{ $order->packing_at->format('d M Y, H:i') }}</strong></li>
                                @endif
                                @if($order->shipped_at)
                                    <li>Shipped: <strong>{{ $order->shipped_at->format('d M Y, H:i') }}</strong></li>
                                @endif
                                @if($order->completed_at)
                                    <li>Completed: <strong>{{ $order->completed_at->format('d M Y, H:i') }}</strong></li>
                                @endif
                                @if($order->cancelled_at)
                                    <li>Cancelled: <strong>{{ $order->cancelled_at->format('d M Y, H:i') }}</strong></li>
                                @endif
                                @if($order->cancelled_by_system_at)
                                <li>Cancelled: <strong>{{ $order->cancelled_by_system_at->format('d M Y, H:i') }}</strong></li>
                            @endif

                            </ul>
                        </div>

                        <p class="h5 mt-3">Total Amount: <strong class="text-primary">Rp{{ number_format($order->total, 0, ',', '.') }}</strong></p>

                        <!-- Order Items -->
                        <h5 class="fw-bold mt-4">Items</h5>
                        <table class="table table-hover mt-3">
                            <thead class="bg-light">
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

                        @if($order->status === 'completed')
                        <div class="mt-5">
                            <h5 class="fw-bold">Write a Review</h5>
                            <ul class="list-unstyled">
                                @foreach($order->items as $item)
                                    @php
                                        // Check if the review exists for this product and order
                                        $reviewExists = $item->product->reviews()
                                            ->where('user_id', auth()->id())
                                            ->where('order_id', $order->id)
                                            ->exists();
                                    @endphp

                                    @if(!$reviewExists)
                                        <li>
                                            <a href="{{ route('customer.product.show', ['slug' => $item->product->slug]) }}?order={{ $order->id }}" class="btn btn-outline-primary">
                                                Review {{ $item->product->name }}
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <span class="text-muted">You have already reviewed {{ $item->product->name }} for this order.</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif



                        <!-- Cancel Order if Pending -->
                        @if($order->status === 'pending')
                        <div class="mt-4">
                            <form action="{{ route('customer.order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger">Cancel Order</button>
                            </form>
                        </div>
                        @endif

                        <!-- Mark as Completed if Shipped -->
                        @if($order->status === 'shipped')
                        <div class="mt-4">
                            <form action="{{ route('customer.complete.order', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Mark as Completed</button>
                            </form>
                        </div>
                        @endif

                        <!-- Payment Proof Submission -->
                        @if($order->status == 'approved')
                            <div class="mt-5">
                                <h5 class="fw-bold">Submit Payment Proof</h5>
                                <div class="alert alert-warning" role="alert">
                                    <strong>Penting!</strong> Jika Anda mengupload atau mengirim bukti pembayaran yang salah, pesanan Anda akan dibatalkan secara otomatis oleh sistem. Kami tidak bertanggung jawab atas kesalahan transfer.
                                </div>

                                @php
                                    // Calculate the time left for payment (48 hours)
                                    $approvedTime = $order->approved_at; // The timestamp when the order was approved
                                    $timeLimit = 48 * 60 * 60; // 48 hours in seconds
                                    $currentTime = now(); // Current timestamp
                                    $elapsedTime = $currentTime->diffInSeconds($approvedTime); // Time elapsed since approved
                                    $remainingTime = max(0, $timeLimit - $elapsedTime); // Calculate remaining time
                                    $hours = floor($remainingTime / 3600); // Calculate hours only
                                @endphp

                                <div id="countdown-timer" class="mt-2">
                                    Waktu tersisa untuk menyelesaikan pembayaran: <strong>{{ $hours }} jam</strong>.
                                </div> <!-- Countdown timer display -->

                                <form action="{{ route('customer.payment.submit', $order->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="payment_proof" class="form-label">Upload Payment Proof</label>
                                        <input type="file" class="form-control" name="payment_proof" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">Submit Payment</button>
                                </form>
                            </div>

                            <script>
                                // Set the countdown time in seconds for this order
                                let remainingTime = {{ $remainingTime }};
                                
                                function updateTimer() {
                                    // Calculate hours only
                                    const hours = Math.floor(remainingTime / 3600);

                                    // Display the countdown timer
                                    document.getElementById('countdown-timer').innerHTML = 
                                        `Waktu tersisa untuk menyelesaikan pembayaran: <strong>${hours} jam</strong>.`;

                                    // If time is up, you can implement logic to handle this case
                                    if (remainingTime <= 0) {
                                        clearInterval(timerInterval);
                                        // Logic to cancel the order can be added here (optional)
                                    }

                                    remainingTime--; // Decrease the remaining time by one second
                                }

                                // Update timer every second
                                const timerInterval = setInterval(updateTimer, 1000);
                                updateTimer(); // Initial call to display timer immediately
                            </script>
                        @endif




                        <!-- Payment Details -->
                        @if($order->payments->isNotEmpty())
                        <div class="mt-5">
                            <h5 class="fw-bold">Payment Details</h5>
                            <table class="table table-bordered">
                                <thead class="bg-light">
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
                        <div class="mt-5">
                            <h5 class="fw-bold">Shipping Information</h5>
                            <p>Shipping Service: <strong>{{ $order->shippingService->name ?? 'Not specified' }}</strong></p>
                            <p>Tracking Number: <strong>{{ $order->tracking_number }}</strong></p>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles for Better Layout -->
<style>
    .card-body {
        padding: 30px;
    }
    .table {
        margin-bottom: 30px;
    }
    .table th {
        text-transform: uppercase;
        font-size: 0.85rem;
    }
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    .btn {
        font-size: 0.9rem;
        padding: 10px 20px;
    }
</style>

@endsection

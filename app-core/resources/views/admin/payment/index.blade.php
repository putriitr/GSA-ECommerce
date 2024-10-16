@extends('layouts.admin.master')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Payments</h1>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->order_id }}</td>
                        <td>{{ optional($payment->order->user)->full_name ?? optional($payment->order->user)->name }}</td>
                        <td>
                            {{ ucfirst($payment->status) }}
                            @if (!$payment->is_viewed) <!-- Check if payment is not viewed -->
                                <span class="badge bg-danger ms-2">New</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#paymentModal-{{ $payment->id }}">View Details</button>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="paymentModal-{{ $payment->id }}" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="paymentModalLabel">Payment Details - ID: {{ $payment->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h6><strong>Order ID:</strong> {{ $payment->order_id }}</h6>
                                    <h6><strong>Customer:</strong> {{ optional($payment->order->user)->full_name ?? optional($payment->order->user)->name }}</h6>
                                    <h6><strong>Status:</strong> {{ ucfirst($payment->status) }}</h6>
                                    <h6><strong>Payment Proof:</strong></h6>
                                    @if($payment->payment_proof)
                                        <div class="mb-3">
                                            @if(in_array(pathinfo($payment->payment_proof, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                <img src="{{ asset($payment->payment_proof) }}" alt="Payment Proof" class="img-fluid mb-2" style="max-width: 100%; height: auto; border-radius: 5px;">
                                            @else
                                                <a href="{{ asset($payment->payment_proof) }}" target="_blank" class="btn btn-primary">View Proof</a>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">No proof uploaded</span>
                                    @endif
                                    <hr>
                                    @if($payment->status === 'pending')
                                        <div class="d-flex justify-content-between">
                                            <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success">Verify Payment</button>
                                            </form>
                                            <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this payment?')">Reject</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin.master')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Manage Payments</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Payments Section -->
    <h2 class="mb-4">Payments</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Payment Proof</th> <!-- New column for payment proof -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->order_id }}</td>
                <td>{{ $payment->order->user->full_name }}</td>
                <td>{{ ucfirst($payment->status) }}</td>
                <td>
                    @if($payment->payment_proof)
                        <!-- Check if the file is an image, display it, else provide a link -->
                        @if(in_array(pathinfo($payment->payment_proof, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                            <a href="{{ asset($payment->payment_proof) }}" target="_blank">
                                <img src="{{ asset($payment->payment_proof) }}" alt="Payment Proof" class="img-thumbnail" style="width: 100px; height: auto;">
                            </a>
                        @else
                            <a href="{{ asset($payment->payment_proof) }}" target="_blank" class="btn btn-primary btn-sm">View Proof</a>
                        @endif
                    @else
                        <span class="text-muted">No proof uploaded</span>
                    @endif
                </td>
                <td>
                    @if($payment->status === 'pending')
                        <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">Verify Payment</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

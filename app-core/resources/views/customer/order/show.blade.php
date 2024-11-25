@extends('layouts.customer.master')

@section('content')

<?php 
use Carbon\Carbon;
use App\Models\Parameter; // Memanggil model di bagian atas
use App\Models\Order;

// Mengambil semua data dari tabel parameters
$parameters = Parameter::first();
?>

<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <!-- Order Details -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Order Details di Kiri -->
                            <h4 class="fw-bold mb-0">{{ __('messages.title_order') }} (#{{ $order->id }})</h4>
                            
                            <!-- Tombol di Kanan -->
                            <div class="d-flex align-items-center">
                                @if(in_array($order->status, ['approved', 'pending_payment', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'cancelled_by_admin', 'cancelled_by_system']))
                                    <a href="{{ route('customer.order.invoice', $order->id) }}" class="btn btn-primary me-2">
                                        <i class="fas fa-download"></i> {{ __('messages.invoice.download') }}
                                    </a>
                                @endif
                                @if(in_array($order->status, ['waiting_approval', 'approved', 'pending_payment', 'confirmed', 'processing']))
                                    <!-- Tombol Batalkan -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                                        <i class="fas fa-times-circle"></i> {{ __('messages.button') }}
                                    </button>
                        
                                    <!-- Modal Konfirmasi -->
                                    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="cancelOrderModalLabel">
                                                        <i class="fas fa-exclamation-triangle text-warning"></i> {{ __('messages.modal.title') }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ __('messages.modal.message') }}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.modal.no') }}</button>
                                                    <form action="{{ route('customer.order.cancel', $order->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-times-circle"></i> {{ __('messages.modal.yes') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        
                        <div class="row mt-4">
                            <!-- Bagian Kiri: Status dan Harga -->
                            <div class="col-md-7">
                                <p class="fw-bold">{{ __('messages.invoice_number') }}: {{ $order->invoice_number }}</p>
                                <p>{{ __('messages.status') }}: 
                                    @if ($order->status == Order::STATUS_WAITING_APPROVAL)
                                        <span class="badge bg-warning">{{ __('messages.statuses.waiting_approval') }}</span>
                                    @elseif ($order->status == Order::STATUS_APPROVED)
                                        <span class="badge bg-info">{{ __('messages.statuses.approved') }}</span>
                                    @elseif ($order->status == Order::STATUS_PENDING_PAYMENT)
                                        <span class="badge bg-warning">{{ __('messages.statuses.pending_payment') }}</span>
                                    @elseif ($order->status == Order::STATUS_CONFIRMED)
                                        <span class="badge bg-success">{{ __('messages.statuses.confirmed') }}</span>
                                    @elseif ($order->status == Order::STATUS_PROCESSING)
                                        <span class="badge bg-primary text-white">{{ __('messages.statuses.processing') }}</span>
                                    @elseif ($order->status == Order::STATUS_SHIPPED)
                                        <span class="badge bg-primary">{{ __('messages.statuses.shipped') }}</span>
                                    @elseif ($order->status == Order::STATUS_DELIVERED)
                                        <span class="badge bg-success">{{ __('messages.statuses.delivered') }}</span>
                                    @elseif ($order->status == Order::STATUS_CANCELLED)
                                        <span class="badge bg-warning">{{ __('messages.statuses.cancelled') }}</span>
                                    @elseif ($order->status == Order::STATUS_CANCELLED_BY_ADMIN)
                                        <span class="badge bg-danger">{{ __('messages.statuses.cancelled_by_admin') }}</span>
                                    @elseif ($order->status == Order::STATUS_CANCELLED_BY_SYSTEM)
                                        <span class="badge bg-danger">{{ __('messages.statuses.cancelled_by_system') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ __('messages.statuses.default') }}</span>
                                    @endif
                                </p>
                        
                                <!-- Display timestamps for status changes -->
                                <div class="mt-3">
                                    <h6 class="fw-bold mb-3 text-primary d-flex align-items-center" role="button" data-bs-toggle="collapse" data-bs-target="#orderHistory" aria-expanded="false" aria-controls="orderHistory">
                                        {{ __('messages.history.title') }}
                                        <i class="ms-2 fas fa-chevron-down transition-icon"></i>
                                    </h6>
                                    <div class="collapse mt-2" id="orderHistory">
                                        <ul class="list-unstyled p-3 bg-light rounded shadow-sm">
                                            @if($order->created_at)
                                                <li class="mb-2">
                                                    <strong>{{ __('messages.history.created') }}</strong>: {{ $order->created_at->format('d M Y, H:i') }}
                                                </li>
                                            @endif
                                            @if($order->approved_at)
                                                <li class="mb-2">
                                                    <strong>{{ __('messages.history.approved') }}</strong>: {{ Carbon::parse($order->approved_at)->format('d M Y, H:i') }}
                                                </li>
                                            @endif
                                            @if($order->pending_payment_at)
                                                <li class="mb-2">
                                                    <strong>{{ __('messages.history.pending_payment') }}</strong>: {{ Carbon::parse($order->pending_payment_at)->format('d M Y, H:i') }}
                                                </li>
                                            @endif
                                            @if($order->processing_at)
                                                <li class="mb-2">
                                                    <strong>{{ __('messages.history.processing') }}</strong>: {{ Carbon::parse($order->processing_at)->format('d M Y, H:i') }}
                                                </li>
                                            @endif
                                            @if($order->shipped_at)
                                                <li class="mb-2">
                                                    <strong>{{ __('messages.history.shipped') }}</strong>: {{ Carbon::parse($order->shipped_at)->format('d M Y, H:i') }}
                                                </li>
                                            @endif
                                            @if($order->delivered_at)
                                                <li class="mb-2">
                                                    <strong>{{ __('messages.history.delivered') }}</strong>: {{ Carbon::parse($order->delivered_at)->format('d M Y, H:i') }}
                                                </li>
                                            @endif
                                            @if($order->cancelled_at)
                                                <li class="mb-2 text-danger">
                                                    <strong>{{ __('messages.history.cancelled') }}</strong>: {{ Carbon::parse($order->cancelled_at)->format('d M Y, H:i') }}
                                                </li>
                                            @endif
                                            @if($order->cancelled_by_admin_at)
                                                <li class="mb-2 text-danger">
                                                    <strong>{{ __('messages.history.cancelled_by_admin') }}</strong>: {{ Carbon::parse($order->cancelled_by_admin_at)->format('d M Y, H:i') }}
                                                </li>
                                            @endif
                                            @if($order->cancelled_by_system_at)
                                                <li class="mb-2 text-danger">
                                                    <strong>{{ __('messages.history.cancelled_by_system') }}</strong>: {{ Carbon::parse($order->cancelled_by_system_at)->format('d M Y, H:i') }}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                
                                <!-- CSS -->
                                <style>
                                .transition-icon {
                                    transition: transform 0.3s ease;
                                }
                                
                                .collapse.show + .fw-bold > .transition-icon {
                                    transform: rotate(180deg);
                                }
                                </style>
                                
                        
                                <p class="h5 mt-3">{{ __('messages.total_amount') }}: <strong class="text-primary">Rp{{ number_format($order->total, 0, ',', '.') }}</strong></p>
                            </div>
                        
                            <!-- Bagian Kanan: Shipping Information -->
                            @if($order->status == 'shipped')
                            <div class="col-md-5 text-end">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body p-4">
                                        <h5 class="fw-bold text-dark">{{ __('messages.shipping_information.title') }}</h5>
                                        <p>{{ __('messages.shipping_information.service') }}: 
                                            <strong>{{ $order->shippingService->name ?? __('messages.shipping_information.not_specified') }}</strong>
                                        </p>
                                        <p>{{ __('messages.shipping_information.tracking_number') }}: 
                                            <strong class="bg-warning px-2 py-1 rounded">{{ $order->tracking_number }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($order->status === 'shipped')
                            <div class="mt-4 text-end">
                                <form action="{{ route('customer.complete.order', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success">{{ __('messages.actions.mark_completed') }}</button>
                                </form>
                            </div>
                            @endif
                        </div>
<!-- Order Items -->
<div class="mt-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-0">
            <h5 class="fw-bold text-dark mb-0">{{ __('messages.items.title') }}</h5>
        </div>
        <div class="card-body p-4">
            <table class="table table-borderless align-middle">
                <thead class="border-bottom">
                    <tr>
                        <th class="text-start text-secondary">{{ __('messages.items.product') }}</th>
                        <th class="text-center text-secondary">{{ __('messages.items.quantity') }}</th>
                        <th class="text-end text-secondary">{{ __('messages.items.price') }}</th>
                        <th class="text-end text-secondary">{{ __('messages.items.total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr class="border-bottom">
                        <td class="text-start text-dark fw-semibold">{{ $item->product->name }}</td>
                        <td class="text-center text-dark">{{ $item->quantity }}</td>
                        <td class="text-end text-dark">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-end text-dark">Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

    @if($order->status === 'delivered')
    <div class="mt-4 bg-light p-4 rounded mb-4">
        <h5 class="fw-bold">{{ __('messages.title') }}</h5>
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
                    <li class="mb-2">
                        <a href="{{ route('customer.product.show', ['slug' => $item->product->slug]) }}?order={{ $order->id }}" class="btn btn-outline-primary">
                            {{ __('messages.review_button', ['product' => $item->product->name]) }}
                        </a>
                    </li>
                @else
                    <li>
                        <span class="text-muted">{{ __('messages.already_reviewed', ['product' => $item->product->name]) }}</span>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    @endif




                        <!-- Cancel Order if Pending -->
@if($order->status === 'pending')
<div class="mt-4">
    <form action="{{ route('customer.order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('{{ __('messages.actions.confirm_cancel') }}');">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-danger">{{ __('messages.actions.cancel_order') }}</button>
    </form>
</div>
@endif

<!-- Mark as Completed if Shipped -->


@if($order->status === 'approved')
<div class="alert alert-warning mt-5" role="alert">
    <strong>{{ __('messages.alerts.approved.title') }}</strong> {{ __('messages.alerts.approved.message') }}
</div>
@endif


                        <!-- Payment Proof Submission -->
                        @if($order->status == 'pending_payment')
                        <div class="mt-5">
                            <h5 class="fw-bold">{{ __('messages.payment.upload_title') }}</h5>
                    
                            <!-- Notifikasi mengenai konsekuensi pembayaran -->
                            <div class="alert alert-warning" role="alert">
                                <strong>{{ __('messages.payment.warning.title') }}</strong>
                                {{ __('messages.payment.warning.message') }}
                                <ul>
                                    <li>{{ __('messages.payment.warning.errors.insufficient_amount') }}</li>
                                    <li>{{ __('messages.payment.warning.errors.excessive_amount') }}</li>
                                    <li>{{ __('messages.payment.warning.errors.wrong_account') }}</li>
                                </ul>
                                {{ __('messages.payment.warning.consequence') }}
                            </div>
                    
                            @php
                                // Hitung sisa waktu pembayaran (48 jam)
                                $approvedTime = $order->approved_at; // Waktu order disetujui
                                $timeLimit = 48 * 60 * 60; // 48 jam dalam detik
                                $currentTime = now(); // Waktu saat ini
                                $elapsedTime = $currentTime->diffInSeconds($approvedTime); // Waktu yang telah berlalu
                                $remainingTime = max(0, $timeLimit - $elapsedTime); // Sisa waktu
                                $hours = floor($remainingTime / 3600); // Jam tersisa
                    
                                // Cek jumlah pembayaran yang diupload
                                $paymentAttempts = $order->payments->count();
                                $latestPaymentStatus = $order->payments->last()->status ?? null; // Status pembayaran terakhir
                            @endphp
                    
                            <!-- Tampilkan Error -->
                            @if(session('error'))
                                <div class="alert alert-danger" role="alert">
                                    <strong>Error:</strong> {{ session('error') }}
                                </div>
                            @endif
                    
                            <!-- Tampilkan Validation Errors -->
                            @if($errors->any())
                                <div class="alert alert-danger rounded shadow-sm p-3" role="alert">
                                    <h5 class="fw-bold text-danger mb-2">
                                        <i class="fas fa-exclamation-circle me-2"></i> {{ __('messages.errors.title') }}
                                    </h5>
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                    
                            @if($paymentAttempts == 0 || ($latestPaymentStatus === 'failed' && $paymentAttempts < 2))
                                <!-- Notifikasi jika pembayaran gagal -->
                                @if($latestPaymentStatus === 'failed')
                                    <div class="alert alert-danger" role="alert">
                                        {{ __('messages.payment.failed.notification') }}
                                    </div>
                                @endif
                    
                                <!-- Timer sisa waktu -->
                                <div id="countdown-timer" class="mt-2">
                                    {{ __('messages.payment.remaining_time', ['hours' => $hours]) }}
                                </div>
                    
                                <!-- Form upload -->
                                <form action="{{ route('customer.payment.submit', $order->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="payment_proof" class="form-label">{{ __('messages.payment.upload_title') }}</label>
                                        <input type="file" class="form-control" name="payment_proof" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">{{ __('messages.payment.submit_payment') }}</button>
                                </form>
                            @elseif($paymentAttempts >= 2 && $latestPaymentStatus === 'failed')
                                <!-- Notifikasi jika user sudah melebihi batas upload -->
                                <div class="alert alert-danger" role="alert">
                                    {{ __('messages.payment.failed.limit_reached') }}
                                </div>
                            @else
                                <!-- Notifikasi jika pembayaran sedang diproses -->
                                <div class="alert alert-success" role="alert">
                                    {{ __('messages.payment.success_processing') }}
                                </div>
                            @endif
                        </div>
                    
                        <!-- Timer Script -->
                        <script>
                            let remainingTime = {{ $remainingTime }};
                            function updateTimer() {
                                const hours = Math.floor(remainingTime / 3600);
                                document.getElementById('countdown-timer').innerHTML = 
                                    `{{ __('messages.payment.remaining_time', ['hours' => ':hours']) }}`.replace(':hours', hours);
                                if (remainingTime <= 0) {
                                    clearInterval(timerInterval);
                                    document.getElementById('countdown-timer').innerHTML =
                                        `{{ __('messages.payment.time_expired') }}`;
                                }
                                remainingTime--;
                            }
                            const timerInterval = setInterval(updateTimer, 1000);
                            updateTimer();
                        </script>
                    @endif
                    
                    


                    @if($order->payments->where('status', 'pending')->isNotEmpty())
                    <div class="alert alert-warning mt-2" role="alert">
                        <strong>{{ __('messages.payment.pending.title') }}</strong> 
                        {!! __('messages.payment.pending.message', ['number' => $parameters->nomor_wa]) !!}
                    </div>
                    @endif
                    
                    @if($order->payments->where('status', 'failed')->isNotEmpty())
                        @if($order->status === 'payment_pending')
                            <div class="alert alert-danger mt-2" role="alert">
                                <strong>{{ __('messages.payment.failed.warning.title') }}</strong> 
                                {{ __('messages.payment.failed.warning.message') }}
                            </div>
                        @elseif($order->status === 'cancelled_by_system')
                            <div class="alert alert-danger mt-2" role="alert">
                                <strong>{{ __('messages.payment.failed.cancelled.title') }}</strong> 
                                {{ __('messages.payment.failed.cancelled.message') }}
                            </div>
                        @endif
                    @endif
                    
                    
                    




                        <!-- Payment Details -->
                        @if($order->payments->isNotEmpty())
                        <div class="mt-5">
                            <div class="card shadow-sm border-0 rounded-3">
                                <div class="card-header bg-white border-0">
                                    <h5 class="fw-bold text-dark mb-0">{{ __('messages.payment_details.title') }}</h5>
                                </div>
                                <div class="card-body p-4">
                                    <table class="table table-borderless align-middle">
                                        <thead class="border-bottom">
                                            <tr>
                                                <th class="text-start text-secondary" style="width: 40%;">{{ __('messages.payment_details.proof') }}</th>
                                                <th class="text-center text-secondary" style="width: 30%;">{{ __('messages.payment_details.status') }}</th>
                                                <th class="text-end text-secondary" style="width: 30%;">{{ __('messages.payment_details.date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->payments as $payment)
                                            <tr class="border-bottom">
                                                <td class="text-start">
                                                    <a href="{{ asset($payment->payment_proof) }}" target="_blank" class="text-decoration-none text-primary fw-semibold">
                                                        {{ __('messages.payment_details.view_proof') }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge px-3 py-2 rounded-pill {{ $payment->status == 'verified' ? 'bg-success text-white' : 'bg-warning text-dark' }}">
                                                        {{ ucfirst($payment->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-end text-dark">
                                                    {{ $payment->created_at->format('d M Y, H:i') }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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

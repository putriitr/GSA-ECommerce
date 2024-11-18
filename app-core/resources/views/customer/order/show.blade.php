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
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="fw-bold">Order Details (#{{ $order->id }})</h4>
                            @if(in_array($order->status, ['approved', 'pending_payment', 'confirmed', 'processing','shipped','delivered','cancelled']))
                                <a href="{{ route('customer.order.invoice', $order->id) }}" class="btn btn-primary">Download Invoice</a>
                            @endif
                        </div>
                        <p class="fw-bold">Invoice Number: {{ $order->invoice_number }}</p>
                        <p>Status: 
                            @if ($order->status == Order::STATUS_WAITING_APPROVAL)
                                <span class="badge bg-warning">Menunggu Persetujuan</span>
                            @elseif ($order->status == Order::STATUS_APPROVED)
                                <span class="badge bg-info">Disetujui</span>
                            @elseif ($order->status == Order::STATUS_PENDING_PAYMENT)
                                <span class="badge bg-warning">Menunggu Pembayaran</span>
                            @elseif ($order->status == Order::STATUS_CONFIRMED)
                                <span class="badge bg-success">Dikonfirmasi</span>
                            @elseif ($order->status == Order::STATUS_PROCESSING)
                                <span class="badge bg-primary text-white">Diproses</span>
                            @elseif ($order->status == Order::STATUS_SHIPPED)
                                <span class="badge bg-primary">Dikirim</span>
                            @elseif ($order->status == Order::STATUS_DELIVERED)
                                <span class="badge bg-success">Tiba di Tujuan</span>
                            @elseif ($order->status == Order::STATUS_CANCELLED)
                                <span class="badge bg-warning">Dibatalkan</span>
                            @elseif ($order->status == Order::STATUS_CANCELLED_BY_ADMIN)
                                <span class="badge bg-danger">Dibatalkan oleh Admin</span>
                            @elseif ($order->status == Order::STATUS_CANCELLED_BY_SYSTEM)
                                <span class="badge bg-danger">Dibatalkan oleh Sistem</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                            @endif
                        </p>
                        

                        <!-- Display timestamps for status changes -->
                        <div class="mt-3">
                            <h6 class="fw-bold">Riwayat Status:</h6>
                            <ul class="list-unstyled">
                                @if($order->created_at)
                                    <li>Pesanan Dibuat: <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong></li>
                                @endif
                                @if($order->approved_at)
                                    <li>Disetujui: <strong>{{ Carbon::parse($order->approved_at)->format('d M Y, H:i') }}</strong></li>
                                @endif
                                @if($order->pending_payment_at)
                                    <li>Menunggu Pembayaran: <strong>{{ Carbon::parse($order->pending_payment_at)->format('d M Y, H:i') }}</strong></li>
                                @endif
                                @if($order->processing_at)
                                    <li>Diproses: <strong>{{ Carbon::parse($order->processing_at)->format('d M Y, H:i') }}</strong></li>
                                @endif
                                @if($order->shipped_at)
                                    <li>Dikirim: <strong>{{ Carbon::parse($order->shipped_at)->format('d M Y, H:i') }}</strong></li>
                                @endif
                                @if($order->delivered_at)
                                    <li>Selesai: <strong>{{ Carbon::parse($order->delivered_at)->format('d M Y, H:i') }}</strong></li>
                                @endif
                                @if($order->cancelled_at)
                                    <li>Dibatalkan: <strong>{{ Carbon::parse($order->cancelled_at)->format('d M Y, H:i') }}</strong></li>
                                @endif
                                @if($order->cancelled_by_admin_at)
                                    <li>Dibatalkan oleh Admin: <strong>{{ Carbon::parse($order->cancelled_by_admin_at)->format('d M Y, H:i') }}</strong></li>
                                @endif
                                @if($order->cancelled_by_system_at)
                                    <li>Dibatalkan oleh Sistem: <strong>{{ Carbon::parse($order->cancelled_by_system_at)->format('d M Y, H:i') }}</strong></li>
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

                        @if($order->status === 'delivered')
                        <div class="mt-4 bg-light p-4 rounded mb-4">
                            <h5 class="fw-bold">Give a Review</h5>
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
                        
                        @if($order->status === 'approved')
                        <div class="alert alert-warning" role="alert">
                            <strong>Mohon Bersabar!</strong> Menunggu Admin Memberikan Akses Pembayaran
                        </div>
                        @endif

                        <!-- Payment Proof Submission -->
                        @if($order->status == 'pending_payment')
                        <div class="mt-5">
                            <h5 class="fw-bold">Upload Bukti Pembayaran</h5>
                    
                            <!-- Notifikasi mengenai konsekuensi pembayaran -->
                            <div class="alert alert-warning" role="alert">
                                <strong>Penting!</strong>
                                Harap memastikan bukti pembayaran Anda benar. 
                                Kesalahan transfer, termasuk:
                                <ul>
                                    <li>Jumlah pembayaran kurang</li>
                                    <li>Jumlah pembayaran lebih</li>
                                    <li>Kesalahan nomor rekening tujuan</li>
                                </ul>
                                akan menyebabkan sistem secara otomatis <strong>membatalkan pesanan Anda</strong>. 
                                Kami tidak bertanggung jawab atas kekurangan atau kelebihan transfer.
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
                                        <i class="fas fa-exclamation-circle me-2"></i> Terjadi Kesalahan
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
                                        <strong>Penting!</strong> Bukti pembayaran Anda sebelumnya ditolak. Mohon upload ulang bukti pembayaran dengan benar. Anda memiliki kesempatan terakhir untuk menyelesaikan pembayaran.
                                    </div>
                                @endif
                    
                                <!-- Timer sisa waktu -->
                                <div id="countdown-timer" class="mt-2">
                                    Waktu tersisa untuk menyelesaikan pembayaran: <strong>{{ $hours }} jam</strong>.
                                </div>
                    
                                <!-- Form upload -->
                                <form action="{{ route('customer.payment.submit', $order->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="payment_proof" class="form-label">Upload Bukti Pembayaran</label>
                                        <input type="file" class="form-control" name="payment_proof" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">Submit Payment</button>
                                </form>
                            @elseif($paymentAttempts >= 2 && $latestPaymentStatus === 'failed')
                                <!-- Notifikasi jika user sudah melebihi batas upload -->
                                <div class="alert alert-danger" role="alert">
                                    <strong>Pembayaran Gagal!</strong> Anda telah melewati batas maksimum upload bukti pembayaran. Silakan hubungi admin untuk informasi lebih lanjut.
                                </div>
                            @else
                                <!-- Notifikasi jika pembayaran sedang diproses -->
                                <div class="alert alert-success" role="alert">
                                    <strong>Pembayaran Diproses!</strong> Bukti pembayaran Anda telah diunggah dan sedang menunggu konfirmasi admin.
                                </div>
                            @endif
                        </div>
                    
                        <!-- Timer Script -->
                        <script>
                            // Set waktu hitung mundur dalam detik
                            let remainingTime = {{ $remainingTime }};
                    
                            function updateTimer() {
                                // Hitung jam
                                const hours = Math.floor(remainingTime / 3600);
                    
                                // Tampilkan timer
                                document.getElementById('countdown-timer').innerHTML =
                                    `Waktu tersisa untuk menyelesaikan pembayaran: <strong>${hours} jam</strong>.`;
                    
                                // Hentikan jika waktu habis
                                if (remainingTime <= 0) {
                                    clearInterval(timerInterval);
                                    document.getElementById('countdown-timer').innerHTML =
                                        `<strong>Waktu telah habis untuk pembayaran.</strong>`;
                                }
                    
                                remainingTime--; // Kurangi waktu per detik
                            }
                    
                            // Perbarui timer setiap detik
                            const timerInterval = setInterval(updateTimer, 1000);
                            updateTimer(); // Panggil sekali untuk menampilkan langsung
                        </script>
                    @endif
                    
                    


                        @if($order->payments->where('status', 'pending')->isNotEmpty())
                            <div class="alert alert-warning mt-2" role="alert">
                                <strong>Mohon Bersabar!</strong> 
                                Kami sedang memproses bukti pembayaran Anda. Jika Anda merasa telah menunggu terlalu lama, 
                                silakan hubungi admin melalui 
                                <a href="https://wa.me/{{ $parameters->nomor_wa }}" target="_blank">
                                    {{ $parameters->nomor_wa }}
                                </a>.
                            </div>
                        @endif


                        @if($order->payments->where('status', 'failed')->isNotEmpty())
                        @if($order->status === 'payment_pending')
                            <div class="alert alert-danger mt-2" role="alert">
                                <strong>Hati Hati!</strong> Silahkan lakukan pembayaran kembali, dan Anda hanya memiliki 1 kesempatan lagi sebelum pesanan Anda dibatalkan oleh sistem karena terdeteksi kejanggalan dalam pembayaran Anda.
                            </div>
                        @elseif($order->status === 'cancelled_by_system')
                            <div class="alert alert-danger mt-2" role="alert">
                                <strong>Pesanan Dibatalkan!</strong>  Pesanan Anda telah dibatalkan oleh sistem karena terdeteksi adanya aktivitas yang mencurigakan dan berpotensi merugikan. Mohon diperhatikan untuk transaksi berikutnya.
                            </div>
                        @endif
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
                            <p>Tracking Number: <strong class="bg-warning rounded">{{ $order->tracking_number }}</strong></p>
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

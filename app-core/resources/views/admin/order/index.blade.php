@extends('layouts.admin.master')

@section('content')
<div class="container py-5">
    <!-- Kartu untuk Mengelola Pesanan -->
    <div class="card">
        <div class="card-header">
            <h1 class="mb-4">Kelola Pesanan</h1>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Bagian Pencarian dan Filter -->
            <form action="{{ route('admin.orders.index') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama atau invoice" value="{{ request()->search }}">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="invoice" class="form-control" placeholder="Filter berdasarkan Invoice" value="{{ request()->invoice }}">
                    </div>
                    <div class="col-md-2">
                        <select name="total_range" class="form-select">
                            <option value="">-- Pilih Anggaran --</option>
                            <option value="less_1m" {{ request()->total_range == 'less_1m' ? 'selected' : '' }}>Kurang dari 1 Juta</option>
                            <option value="1m_5m" {{ request()->total_range == '1m_5m' ? 'selected' : '' }}>1 Juta - 5 Juta</option>
                            <option value="5m_10m" {{ request()->total_range == '5m_10m' ? 'selected' : '' }}>5 Juta - 10 Juta</option>
                            <option value="10m_up" {{ request()->total_range == '10m_up' ? 'selected' : '' }}>Lebih dari 10 Juta</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="all" {{ request()->status == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                            <option value="approved" {{ request()->status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="payment_verified" {{ request()->status == 'payment_verified' ? 'selected' : '' }}>Pembayaran Diverifikasi</option>
                            <option value="packing" {{ request()->status == 'packing' ? 'selected' : '' }}>Dikemas</option>
                            <option value="shipped" {{ request()->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                            <option value="completed" {{ request()->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ request()->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            <option value="cancelled_by_system" {{ request()->status == 'cancelled_by_system' ? 'selected' : '' }}>Dibatalkan oleh Sistem</option>
                        </select>
                    </div>                    
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search p-1"></i> <!-- Ikon Pencarian -->
                        </button>
                    </div>
                    <div class="col-md-1">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-sync-alt p-1"></i> <!-- Ikon Refresh -->
                        </a>
                    </div>
                </div>
            </form>
            
            <!-- Bagian Pesanan -->
            @if($orders->isEmpty())
                <!-- Tampilkan pesan jika tidak ada hasil -->
                <div class="alert alert-warning text-center" role="alert">
                    Tidak ada pesanan yang sesuai dengan kriteria pencarian atau filter Anda.
                </div>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Invoice</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>
                                <a href="{{ route('customer.order.invoice', $order->id) }}" target="_blank">{{ $order->invoice_number }}</a>
                            </td>                        
                            <td>{{ optional($order->user)->full_name ?? optional($order->user)->name }}</td>
                            <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge 
                                    @switch($order->status)
                                        @case('pending') bg-warning @break
                                        @case('approved') bg-info @break
                                        @case('payment_verified') bg-success @break
                                        @case('packing') bg-primary @break
                                        @case('shipped') bg-secondary @break
                                        @case('completed') bg-success @break
                                        @case('cancelled') bg-danger @break
                                        @case('cancelled_by_system') bg-danger @break
                                        @default bg-light
                                    @endswitch
                                ">
                                    @switch($order->status)
                                        @case('pending')
                                            Menunggu Konfirmasi
                                            @break
                                        @case('approved')
                                            Menunggu Pembayaran
                                            @break
                                        @case('payment_verified')
                                            Pembayaran Diterima
                                            @break
                                        @case('packing')
                                            Diproses
                                            @break
                                        @case('shipped')
                                            Dikirim
                                            @break
                                        @case('completed')
                                            Tiba di Tujuan
                                            @break
                                        @case('cancelled')
                                            Dibatalkan
                                            @break
                                        @case('cancelled_by_system')
                                            Dibatalkan oleh sistem
                                            @break
                                        @default
                                            {{ ucfirst($order->status) }}
                                    @endswitch
                                </span>
                                @if (!$order->is_viewed)
                                    <span class="badge bg-danger ms-2">Baru</span>
                                @endif
                            </td>
                            
                            <td>
                                <!-- Tampilkan Detail Pesanan -->
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif           
        </div>
        <div class="pagination justify-content-center">
            {{ $orders->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection

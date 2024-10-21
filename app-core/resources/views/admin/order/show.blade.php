@extends('layouts.admin.master')

@section('content')
@php
    $statusMap = [
        'pending' => 'Menunggu Persetujuan',
        'approved' => 'Disetujui',
        'payment_verified' => 'Pembayaran Terverifikasi',
        'packing' => 'Sedang Dikemas',
        'shipped' => 'Dikirim',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
        'cancelled_by_system' => 'Dibatalkan oleh Sistem',
    ];

    $statusBgClasses = [
            'pending' => 'bg-warning text-dark',
            'approved' => 'bg-primary text-white',
            'payment_verified' => 'bg-success text-white',
            'packing' => 'bg-info text-white',
            'shipped' => 'bg-primary text-white',
            'completed' => 'bg-success text-white',
            'cancelled' => 'bg-danger text-white',
            'cancelled_by_system' => 'bg-secondary text-white',
        ];
        
@endphp

<div class="container py-5">
    <!-- Judul dan Tombol Aksi -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detail Pesanan - ID Pesanan: {{ $order->id }}</h1>
    
        <!-- Aksi untuk Admin -->
        <div class="d-flex align-items-center gap-2">
            @if($order->status === 'pending')
                <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success btn-sm">Setujui Pesanan</button>
                </form>
            @endif
    
            @if($order->status === 'payment_verified')
                <form action="{{ route('admin.mark.packing', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-warning btn-sm">Tandai Sebagai Dikemas</button>
                </form>
            @endif
    
            @if($order->status === 'packing')
                <!-- Tombol untuk modal pengiriman -->
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#shippingModal">
                    Tandai Sebagai Dikirim
                </button>
            @endif
        </div>
    </div>
    

    @if($order->status === 'approved')
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Menunggu customer melakukan pembayaran</strong> dan menunggu persetujuan admin.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <!-- Bagian Informasi Pesanan -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Informasi Pesanan</h5>
            
            @if($order->status !== 'cancelled' && $order->status !== 'cancelled_by_system')
                <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" class="mb-0">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger btn-sm">Batalkan Pesanan</button>
                </form>
            @endif
        </div>
        
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <th>Nama Pelanggan</th>
                    <td>{{ $order->user->full_name }}</td>
                </tr>
                <tr>
                    <th>Nomor Invoice</th>
                    <td><a href="{{ route('customer.order.invoice', $order->id) }}" target="_blank">{{ $order->invoice_number }}</a></td>
                </tr>
                <tr>
                    <th>Total Pembayaran</th>
                    <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="px-2 py-1 rounded {{ $statusBgClasses[$order->status] ?? 'bg-light text-dark' }}">
                            {{ $statusMap[$order->status] ?? ucfirst($order->status) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Bagian Item Pesanan -->
    <div class="card mb-4">
        <div class="card-header">
            Item Pesanan
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kuantitas</th>
                        <th>Harga</th>
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

    <!-- Bagian Alamat Pelanggan (Hanya tampil jika status adalah 'packing') -->
    @if($order->status === 'packing')
    <div class="card mb-4">
        <div class="card-header">
            Alamat Pelanggan
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
                                <th>Detail</th>
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
                    <p>Tidak ada alamat aktif untuk pelanggan ini.</p>
                @endif
            @else
                <p>Informasi pelanggan tidak ditemukan untuk pesanan ini.</p>
            @endif
        </div>
    </div>
    @endif

    <!-- Modal Pengiriman -->
    <div class="modal fade" id="shippingModal" tabindex="-1" aria-labelledby="shippingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shippingModalLabel">Tandai Pesanan Sebagai Dikirim</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.orders.shipped', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Input Nomor Pelacakan -->
                        <div class="mb-3">
                            <label for="tracking_number" class="form-label">Nomor Pelacakan</label>
                            <input type="text" class="form-control" name="tracking_number" required>
                        </div>

                        <!-- Pilihan Layanan Pengiriman -->
                        <div class="mb-3">
                            <label for="shipping_service_id" class="form-label">Layanan Pengiriman</label>
                            <select class="form-select" name="shipping_service_id" required>
                                <option value="" disabled selected>Pilih layanan pengiriman</option>
                                @foreach($shipping as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit" class="btn btn-primary">Tandai Sebagai Dikirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

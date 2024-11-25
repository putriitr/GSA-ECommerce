@extends('layouts.admin.master')

@section('content')
@php
    use App\Models\Order;

    $statusList = [
        'all' => 'Semua Status',
        Order::STATUS_WAITING_APPROVAL => 'Menunggu Persetujuan',
        Order::STATUS_APPROVED => 'Disetujui',
        Order::STATUS_PENDING_PAYMENT => 'Menunggu Pembayaran',
        Order::STATUS_CONFIRMED => 'Pembayaran Dikonfirmasi',
        Order::STATUS_PROCESSING => 'Sedang Dikemas',
        Order::STATUS_SHIPPED => 'Dikirim',
        Order::STATUS_DELIVERED => 'Selesai',
        Order::STATUS_CANCELLED => 'Dibatalkan',
        Order::STATUS_CANCELLED_BY_ADMIN => 'Dibatalkan oleh Admin',
        Order::STATUS_CANCELLED_BY_SYSTEM => 'Dibatalkan oleh Sistem',
    ];
@endphp

<div class="container py-5">
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="orderTabs" role="tablist" style="border-bottom: 1px solid #ddd;">
        <li class="nav-item" role="presentation" style="margin-right: 10px;">
            <button 
                class="nav-link active" 
                id="list-tab" 
                data-bs-toggle="tab" 
                data-bs-target="#list" 
                type="button" 
                role="tab" 
                aria-controls="list" 
                aria-selected="true" 
                style="font-size: 14px; font-weight: 500; color: #333; border: none; background: none; border-bottom: 2px solid transparent; padding: 10px 15px;">
                Daftar Pesanan
            </button>
        </li>
        <li class="nav-item" role="presentation" style="margin-right: 10px;">
            <button 
                class="nav-link" 
                id="chart-tab" 
                data-bs-toggle="tab" 
                data-bs-target="#chart" 
                type="button" 
                role="tab" 
                aria-controls="chart" 
                aria-selected="false" 
                style="font-size: 14px; font-weight: 500; color: #666; border: none; background: none; border-bottom: 2px solid transparent; padding: 10px 15px;">
                Grafik Pesanan
            </button>
        </li>
    </ul>
    

    <!-- Tabs Content -->
    <div class="tab-content mt-4" id="orderTabsContent">
        <!-- Tab 1: List Order -->
        <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
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
                                    <option value="{{ Order::STATUS_WAITING_APPROVAL }}" {{ request()->status == Order::STATUS_WAITING_APPROVAL ? 'selected' : '' }}>Menunggu Persetujuan</option>
                                    <option value="{{ Order::STATUS_APPROVED }}" {{ request()->status == Order::STATUS_APPROVED ? 'selected' : '' }}>Disetujui</option>
                                    <option value="{{ Order::STATUS_PENDING_PAYMENT }}" {{ request()->status == Order::STATUS_PENDING_PAYMENT ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                    <option value="{{ Order::STATUS_CONFIRMED }}" {{ request()->status == Order::STATUS_CONFIRMED ? 'selected' : '' }}>Pembayaran Diverifikasi</option>
                                    <option value="{{ Order::STATUS_PROCESSING }}" {{ request()->status == Order::STATUS_PROCESSING ? 'selected' : '' }}>Dikemas</option>
                                    <option value="{{ Order::STATUS_SHIPPED }}" {{ request()->status == Order::STATUS_SHIPPED ? 'selected' : '' }}>Dikirim</option>
                                    <option value="{{ Order::STATUS_DELIVERED }}" {{ request()->status == Order::STATUS_DELIVERED ? 'selected' : '' }}>Selesai</option>
                                    <option value="{{ Order::STATUS_CANCELLED }}" {{ request()->status == Order::STATUS_CANCELLED ? 'selected' : '' }}>Dibatalkan</option>
                                    <option value="{{ Order::STATUS_CANCELLED_BY_SYSTEM }}" {{ request()->status == Order::STATUS_CANCELLED_BY_SYSTEM ? 'selected' : '' }}>Dibatalkan oleh Sistem</option>
                                    <option value="{{ Order::STATUS_CANCELLED_BY_ADMIN }}" {{ request()->status == Order::STATUS_CANCELLED_BY_ADMIN ? 'selected' : '' }}>Dibatalkan oleh Admin</option>
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
                                    <th class="text-center">Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        <a href="{{ $order->invoice_number ? route('customer.order.invoice', $order->id) : '#' }}">
                                            {{ $order->invoice_number ?? '-' }}
                                        </a>
                                    </td>
                                    <td>{{ optional($order->user)->full_name ?? optional($order->user)->name }}</td>
                                    <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <span class="badge 
                                            @switch($order->status)
                                                @case(Order::STATUS_WAITING_APPROVAL) bg-warning @break
                                                @case(Order::STATUS_APPROVED) bg-info @break
                                                @case(Order::STATUS_PENDING_PAYMENT) bg-success @break
                                                @case(Order::STATUS_CONFIRMED) bg-success @break
                                                @case(Order::STATUS_PROCESSING) bg-primary @break
                                                @case(Order::STATUS_SHIPPED) bg-secondary @break
                                                @case(Order::STATUS_DELIVERED) bg-success @break
                                                @case(Order::STATUS_CANCELLED)
                                                @case(Order::STATUS_CANCELLED_BY_SYSTEM)
                                                @case(Order::STATUS_CANCELLED_BY_ADMIN) bg-danger @break
                                                @default bg-light
                                            @endswitch
                                        ">
                                            @switch($order->status)
                                                @case(Order::STATUS_WAITING_APPROVAL)
                                                    Menunggu Konfirmasi
                                                    @break
                                                @case(Order::STATUS_APPROVED)
                                                    Menunggu Pembayaran
                                                    @break
                                                @case(Order::STATUS_PENDING_PAYMENT)
                                                    Menunggu Pembayaran
                                                    @break
                                                @case(Order::STATUS_CONFIRMED)
                                                    Pembayaran Diterima
                                                    @break
                                                @case(Order::STATUS_PROCESSING)
                                                    Sedang Dikemas
                                                    @break
                                                @case(Order::STATUS_SHIPPED)
                                                    Dikirim
                                                    @break
                                                @case(Order::STATUS_DELIVERED)
                                                    Tiba di Tujuan
                                                    @break
                                                @case(Order::STATUS_CANCELLED)
                                                @case(Order::STATUS_CANCELLED_BY_SYSTEM)
                                                @case(Order::STATUS_CANCELLED_BY_ADMIN)
                                                    Dibatalkan
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

        <!-- Tab 2: Chart Order -->
        <div class="tab-pane fade" id="chart" role="tabpanel" aria-labelledby="chart-tab">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="mb-0">Grafik Pesanan</h3>
                </div>
                <div class="card-body">
                    <!-- Filter Form untuk Grafik -->
                    <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="chart_status" class="form-label">Status Pesanan</label>
                                <select name="chart_status" id="chart_status" class="form-select">
                                    @foreach ($statusList as $statusKey => $statusLabel)
                                        <option value="{{ $statusKey }}" {{ request('chart_status') == $statusKey ? 'selected' : '' }}>
                                            {{ $statusLabel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="from_date" class="form-label">Dari Tanggal</label>
                                <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="to_date" class="form-label">Hingga Tanggal</label>
                                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                            </div>
                            <div class="col-md-2 align-self-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter"></i> Terapkan Filter
                                </button>
                            </div>
                        </div>
                    </form>
        
                    <!-- Chart -->
                    <div class="chart-container" style="position: relative; height: 75%;">
                        <canvas id="orderChart"></canvas>
                    </div>
        
                    <!-- Export Buttons -->
                    <div class="mt-4 d-flex justify-content-between">
                        <button id="exportPng" class="btn btn-success">
                            <i class="fas fa-file-image"></i> Export as PNG
                        </button>
                        <button id="exportExcel" class="btn btn-info">
                            <i class="fas fa-file-excel"></i> Export as Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    // Data for Chart
    const chartOrders = @json($chartOrders);
    const labels = chartOrders.map(order => new Date(order.created_at).toLocaleDateString());
    const data = chartOrders.map(order => order.total);

    // Fungsi untuk menerjemahkan status
    const translateStatus = (status) => {
        switch (status) {
            case '{{ Order::STATUS_WAITING_APPROVAL }}':
                return 'Menunggu Konfirmasi';
            case '{{ Order::STATUS_APPROVED }}':
                return 'Menunggu Pembayaran';
            case '{{ Order::STATUS_PENDING_PAYMENT }}':
                return 'Menunggu Pembayaran';
            case '{{ Order::STATUS_CONFIRMED }}':
                return 'Pembayaran Diterima';
            case '{{ Order::STATUS_PROCESSING }}':
                return 'Sedang Dikemas';
            case '{{ Order::STATUS_SHIPPED }}':
                return 'Dikirim';
            case '{{ Order::STATUS_DELIVERED }}':
                return 'Tiba di Tujuan';
            case '{{ Order::STATUS_CANCELLED }}':
            case '{{ Order::STATUS_CANCELLED_BY_SYSTEM }}':
            case '{{ Order::STATUS_CANCELLED_BY_ADMIN }}':
                return 'Dibatalkan';
            default:
                return status ? status.charAt(0).toUpperCase() + status.slice(1) : '-';
        }
    };

    // Create Chart
    const ctx = document.getElementById('orderChart').getContext('2d');
    const orderChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Pesanan',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.6)', // Warna latar bar yang lebih menarik
                borderColor: 'rgba(75, 192, 192, 1)',      // Warna tepi bar
                borderWidth: 1.5                          // Lebar tepi bar
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top', // Posisi legend di atas
                    labels: {
                        color: '#333', // Warna teks legend
                        font: {
                            size: 14   // Ukuran font legend
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Grafik Total Pesanan',
                    color: '#111', // Warna judul
                    font: {
                        size: 18, // Ukuran font judul
                        weight: 'bold'
                    },
                    padding: {
                        top: 10,
                        bottom: 20
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(0,0,0,0.7)', // Warna latar tooltip
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    cornerRadius: 5
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#555', // Warna teks sumbu X
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        display: false // Hilangkan garis pada sumbu X
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#555', // Warna teks sumbu Y
                        font: {
                            size: 12
                        },
                        callback: function (value) {
                            return 'Rp ' + value.toLocaleString(); // Format angka ke mata uang
                        }
                    },
                    grid: {
                        color: 'rgba(200, 200, 200, 0.3)', // Warna garis grid pada sumbu Y
                        lineWidth: 1
                    }
                }
            }
        }
    });

    // Export as PNG
    document.getElementById('exportPng').addEventListener('click', function() {
        const link = document.createElement('a');
        link.download = 'order_chart.png';
        link.href = orderChart.toBase64Image();
        link.click();
    });

    // Export as Excel
    document.getElementById('exportExcel').addEventListener('click', function() {
        const data = chartOrders.map(order => ({
            Invoice: order.invoice_number ?? '-', // Invoice number
            ID: order.id,                        // Order ID
            Total: order.total,                  // Total amount
            Date: new Date(order.created_at).toLocaleDateString(), // Order Date
            Name: order.user?.full_name ?? order.user?.name ?? '-', // User Name
            Email: order.user?.email ?? '-',     // User Email
            Status: translateStatus(order.status) // Terjemahkan status
        }));

        const worksheet = XLSX.utils.json_to_sheet(data);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Orders');
        XLSX.writeFile(workbook, 'orders.xlsx');
    });
</script>





<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');
        const activeTab = localStorage.getItem('activeTab'); // Ambil tab terakhir dari localStorage

        // Jika ada tab yang tersimpan, aktifkan tab tersebut
        if (activeTab) {
            const tabToActivate = document.querySelector(`[data-bs-target="#${activeTab}"]`);
            if (tabToActivate) {
                const tab = new bootstrap.Tab(tabToActivate);
                tab.show();
            }
        }

        // Simpan tab yang terakhir diklik
        tabButtons.forEach(button => {
            button.addEventListener('shown.bs.tab', function (e) {
                const activeTabId = e.target.getAttribute('data-bs-target').replace('#', '');
                localStorage.setItem('activeTab', activeTabId); // Simpan ID tab aktif
            });
        });
    });
</script>

@endsection



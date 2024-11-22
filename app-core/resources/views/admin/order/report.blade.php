@extends('layouts.admin.master')

@section('content')
<div class="container mt-4">
    <h1>Report Orders</h1>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.orders.report') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="status" class="form-label">Order Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="delivered" {{ $status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="date_range" class="form-label">Date Range</label>
                <select name="date_range" id="date_range" class="form-select">
                    <option value="1_day" {{ $dateRange == '1_day' ? 'selected' : '' }}>1 Day</option>
                    <option value="1_week" {{ $dateRange == '1_week' ? 'selected' : '' }}>1 Week</option>
                    <option value="1_month" {{ $dateRange == '1_month' ? 'selected' : '' }}>1 Month</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <!-- Chart -->
    <canvas id="orderChart"></canvas>

    <!-- Export Buttons -->
    <div class="mt-4">
        <button id="exportPng" class="btn btn-success">Export as PNG</button>
        <button id="exportExcel" class="btn btn-info">Export as Excel</button>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data for the chart
    const orders = @json($orders);

    const labels = orders.map(order => order.created_at); // Dates
    const data = orders.map(order => order.total); // Total order amount

    const ctx = document.getElementById('orderChart').getContext('2d');
    const orderChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Order Amount',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
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
        const data = orders.map(order => ({
            ID: order.id,
            Date: order.created_at,
            Total: order.total
        }));

        const worksheet = XLSX.utils.json_to_sheet(data);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Orders');

        XLSX.writeFile(workbook, 'orders.xlsx');
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
@endsection

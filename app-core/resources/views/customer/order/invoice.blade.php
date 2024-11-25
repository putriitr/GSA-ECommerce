<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->invoice_number }}</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 80px;
            color: #90bfc0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 5px;
            pointer-events: none;
            z-index: -1;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 32px;
            color: #38a3a5;
        }

        .header p {
            font-size: 14px;
            color: #555;
        }

        /* Invoice Details */
        .invoice-details {
            margin-bottom: 30px;
        }

        .invoice-details p {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
        }

        /* Buyer Information */
        .buyer-info {
            margin-bottom: 30px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
        }

        .buyer-info h3 {
            font-size: 16px;
            color: #38a3a5;
            margin-bottom: 10px;
        }

        .buyer-info p {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
        }

        /* Table Section */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 14px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #38a3a5;
            color: #fff;
            font-weight: bold;
        }

        table td {
            color: #555;
        }

        .old-price {
            text-decoration: line-through;
            color: #bdc3c7;
        }

        /* Total Section */
        .total {
            font-size: 20px;
            font-weight: bold;
            color: #e74c3c;
            text-align: right;
        }

        /* Bank Details */
        .bank-details {
            margin-top: 30px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
        }

        .bank-details h3 {
            font-size: 16px;
            color: #38a3a5;
            margin-bottom: 10px;
        }

        .bank-details p {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #f1f1f1;
            padding-top: 10px;
        }

        .footer p {
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Watermark -->
        @if($order->payments->where('status', 'paid')->isNotEmpty())
        <div class="watermark">LUNAS</div>
        @endif
            <!-- Header -->
        <div class="header">
            <h1>INVOICE</h1>
            <p>{{ $parameter->nama_ecommerce }}</p>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <p><strong>Nomor Invoice:</strong> {{ $order->invoice_number ?? 'N/A' }}</p>
            <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y') }}</p>
        </div>

        <!-- Buyer Information -->
        <div class="buyer-info">
            <h3>Informasi Pembeli</h3>
            <p><strong>Nama:</strong> {{ $order->user->full_name ?? $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email ?? 'Tidak Ada' }}</p>
            <p><strong>Alamat:</strong> 
                @if ($order->user->addresses->isNotEmpty())
                    {{ $order->user->addresses->first()->detail_alamat ?? '' }}, 
                    {{ $order->user->addresses->first()->kecamatan ?? '' }}, 
                    {{ $order->user->addresses->first()->kota_kabupaten ?? '' }}, 
                    {{ $order->user->addresses->first()->provinsi ?? '' }}, 
                    {{ $order->user->addresses->first()->kodepos ?? '' }}
                @else
                    Tidak Ada
                @endif
            </p>
        </div>

        <!-- Order Items -->
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Awal</th>
                    <th>Harga Diskon</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>
                        @if ($item->product->discount_price)
                        <span class="old-price">Rp{{ number_format($item->product->price, 0, ',', '.') }}</span>
                        @else
                        Rp{{ number_format($item->product->price, 0, ',', '.') }}
                        @endif
                    </td>
                    <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total -->
        <div class="total">
            Total Tagihan: <strong>Rp{{ number_format($order->total, 0, ',', '.') }}</strong>
        </div>

        <!-- Bank Details -->
        <div class="bank-details">
            <h3>Detail Rekening Bank</h3>
            <p>Silakan lakukan pembayaran ke rekening berikut:</p>
            <p><strong>Bank:</strong> {{ $parameter->bank_vendor ?? 'Tidak Ada' }}</p>
            <p><strong>Nama Pemilik:</strong> {{ $parameter->bank_nama ?? 'Tidak Ada' }}</p>
            <p><strong>Nomor Rekening:</strong> {{ $parameter->bank_rekening ?? 'Tidak Ada' }}</p>
            <p><strong>Batas Waktu:</strong> {{ $order->created_at->addDays(2)->format('d M Y') }}</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Invoice ini dihasilkan oleh sistem komputer secara otomatis dan dianggap sah tanpa memerlukan tanda tangan.</p>
            <p>Terima kasih telah berbelanja di {{ $parameter->nama_ecommerce }}!</p>
        </div>
    </div>
</body>
</html>

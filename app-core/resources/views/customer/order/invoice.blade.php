<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            font-size: 36px;
            margin: 10px 0;
            color: #2c3e50;
        }
        .invoice-details {
            text-align: right;
            margin-bottom: 20px;
        }
        .invoice-details p {
            margin: 5px 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: none;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f8f8;
            color: #333;
        }
        td {
            padding: 15px 10px;
        }
        .total {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
        .total-amount {
            color: #e74c3c;
        }
        .bank-details {
            margin-top: 40px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            border-left: 5px solid #007bff;
        }
        .bank-details h3 {
            margin-bottom: 10px;
            font-size: 20px;
            color: #2c3e50;
        }
        .bank-details p {
            margin: 5px 0;
            font-size: 14px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .footer p {
            margin: 5px 0;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }
        .company-info {
            margin-top: 20px;
            text-align: left;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <h1>INVOICE</h1>
            <p class="company-name">PT. Gudang Solusi Acommerce</p>
        </div>

        <!-- Invoice Information -->
        <div class="invoice-details">
            <p>Invoice #: <strong>{{ $order->id }}</strong></p>
            <p>Date: <strong>{{ $order->created_at->format('d M Y') }}</strong></p>
        </div>

        <!-- Order Items -->
        <h3>Order Summary</h3>
        <table>
            <thead>
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

        <!-- Total Amount -->
        <div class="total">
            Total Amount: <strong class="total-amount">Rp{{ number_format($order->total, 0, ',', '.') }}</strong>
        </div>

        <!-- Bank Details -->
        <div class="bank-details">
            <h3>Bank Account Details</h3>
            <p>Please make your payment to the following account:</p>
            <p><strong>Bank: Bank XYZ</strong></p>
            <p><strong>Account Name: PT. Gudang Solusi Acommerce</strong></p>
            <p><strong>Account Number: 123-456-7890</strong></p>
            <p><strong>Payment Due: {{ now()->addDays(7)->format('d M Y') }}</strong></p>
        </div>

        <!-- Company Information -->
        <div class="company-info">
            <h3>Contact Information</h3>
            <p><strong>Address:</strong> BIZPARK JABABEKA, Jl. Niaga Industri Selatan 2 Blok QQ2 No.6, Kel. Pasirsari, Kec. Cikarang Selatan, Kabupaten Bekasi, Provinsi Jawa Barat</p>
            <p><strong>Email:</strong> info@gsacommerce.com</p>
            <p><strong>WhatsApp:</strong> +62 813-9006-9009</p>
        </div>

        <!-- Footer Section -->
        <div class="footer">
            <p>Thank you for shopping with tokoGSacommerce!</p>
            <p>If you have any questions, feel free to contact us at support@tokoGSacommerce.com</p>
        </div>
    </div>

</body>
</html>

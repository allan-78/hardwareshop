<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .receipt-title {
            font-size: 24px;
            color: #333;
            margin: 0;
        }
        .order-info {
            margin-bottom: 30px;
        }
        .customer-info {
            margin-bottom: 30px;
        }
        h3 {
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        .totals {
            margin-top: 20px;
            text-align: right;
        }
        .total-row {
            margin-bottom: 5px;
        }
        .grand-total {
            font-size: 18px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #ddd;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('images/logo.png') }}" alt="Logo" class="logo">
            <h1 class="receipt-title">Order Receipt</h1>
        </div>

        <div class="order-info">
            <p><strong>Order Number:</strong> #{{ $order->order_number }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        </div>

        <div class="customer-info">
            <h3>Customer Information</h3>
            <p><strong>Name:</strong> {{ $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
            <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
            <p><strong>Shipping Address:</strong><br>
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_city }}, {{ $order->shipping_state }}<br>
                {{ $order->shipping_postal_code }}
            </p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₱{{ number_format($item->price, 2) }}</td>
                    <td>₱{{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="total-row">
                <strong>Subtotal:</strong> ₱{{ number_format($order->subtotal, 2) }}
            </div>
            <div class="total-row">
                <strong>Shipping Fee:</strong> ₱{{ number_format($order->shipping_fee, 2) }}
            </div>
            <div class="grand-total">
                <strong>Total Amount:</strong> ₱{{ number_format($order->total_amount, 2) }}
            </div>
        </div>

        <div class="footer">
            <p>Thank you for shopping with {{ config('app.name') }}!</p>
            <p>For any inquiries, please contact us at {{ config('mail.from.address') }}</p>
            <p>{{ config('app.name') }} | {{ config('app.url') }}</p>
        </div>
    </div>
</body>
</html>
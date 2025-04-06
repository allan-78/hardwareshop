@component('mail::message')
# Order Placed Successfully!

Hello {{ $order->user->name }},

Your order **#{{ $order->order_number }}** has been received and is being processed.

**Order Summary:**
- Subtotal: ₱{{ number_format($order->subtotal, 2) }}
- Shipping: ₱{{ number_format($order->shipping_fee, 2) }}
- **Total: ₱{{ number_format($order->total_amount, 2) }}**

**Shipping Address:**  
{{ $order->shipping_address }}  
{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}

@component('mail::button', ['url' => route('orders.show', $order)])
View Order Details
@endcomponent

Thank you for shopping with us!  
{{ config('app.name') }}
@endcomponent

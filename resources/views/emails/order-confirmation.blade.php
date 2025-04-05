@component('mail::message')
# Order Confirmation

Dear {{ $order->user->name }},

Thank you for your order! We are pleased to confirm that your order (#{{ $order->order_number }}) has been received and is being processed.

## Order Details

@component('mail::table')
| Product | Quantity | Price |
|:--------|:---------|:------|
@foreach($order->items as $item)
| {{ $item->product->name }} | {{ $item->quantity }} | ₱{{ number_format($item->price, 2) }} |
@endforeach
@endcomponent

**Subtotal:** ₱{{ number_format($order->subtotal, 2) }}  
**Shipping Fee:** ₱{{ number_format($order->shipping_fee, 2) }}  
**Total:** ₱{{ number_format($order->total_amount, 2) }}

## Shipping Information
**Address:** {{ $order->shipping_address }}  
**City:** {{ $order->shipping_city }}  
**Phone:** {{ $order->shipping_phone }}

@component('mail::button', ['url' => route('user.orders.show', $order->id)])
View Order Details
@endcomponent

@component('mail::panel')
Your order receipt is attached to this email. Please keep it for your records.
@endcomponent

If you have any questions about your order, please contact our customer service team.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
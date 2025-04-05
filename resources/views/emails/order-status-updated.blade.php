@component('mail::message')
# Order Status Update

Dear {{ $order->user->name }},

Your order (#{{ $order->order_number }}) status has been updated to **{{ ucfirst($order->status) }}**.

@if($order->status === 'processing')
We are currently preparing your items for shipment.
@elseif($order->status === 'shipped')
Your order has been shipped and is on its way to you.

@component('mail::panel')
**Tracking Information**  
Tracking Number: {{ $order->tracking_number }}  
Courier: {{ $order->shipping_courier }}
@endcomponent
@elseif($order->status === 'completed')
Your order has been delivered successfully. We hope you enjoy your purchase!

@component('mail::panel')
If you're satisfied with your purchase, please consider leaving a review.

@component('mail::button', ['url' => route('user.reviews.create', ['product' => $order->items->first()->product_id])])
Write a Review
@endcomponent
@endcomponent
@elseif($order->status === 'cancelled')
Your order has been cancelled. If you did not request this cancellation, please contact our customer service team immediately.
@endif

## Order Summary
**Order Number:** #{{ $order->order_number }}  
**Order Date:** {{ $order->created_at->format('M d, Y') }}  
**Total Amount:** ₱{{ number_format($order->total_amount, 2) }}

@component('mail::button', ['url' => route('user.orders.show', $order->id)])
View Order Details
@endcomponent

@component('mail::panel')
An updated receipt is attached to this email for your records.
@endcomponent

If you have any questions about your order, please don't hesitate to contact our customer service team.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
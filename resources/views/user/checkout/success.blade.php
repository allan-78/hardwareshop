@extends('user.layouts.app')

@section('content')
<div class="container py-5">
    <div class="bg-white rounded-lg shadow px-6 py-8">
        <div class="text-center mb-6">
            <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                <i class="bi bi-check-lg" style="font-size: 2.5rem;"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-900">Order Completed Successfully!</h2>
            <p class="text-muted mt-2">Thank you for your purchase. Your order has been received.</p>
        </div>
        
        <div class="bg-light p-4 rounded mb-5">
            <div class="row">
                <div class="col-md-6">
                    <p class="text-muted small mb-1">Order Number</p>
                    <p class="font-medium">#{{ $order->order_number }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-muted small mb-1">Date</p>
                    <p class="font-medium">{{ $order->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <div class="text-center mb-5">
            <a href="{{ asset($receiptPath) }}" class="btn btn-primary" target="_blank">
                <i class="bi bi-file-earmark-pdf me-2"></i> Download Receipt
            </a>
        </div>

        <div class="border-top pt-5">
            <h3 class="text-lg font-medium text-gray-900 mb-4">What's Next?</h3>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-envelope text-primary"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="h6 mb-2">Confirmation Email</h4>
                            <p class="text-muted small">You'll receive an order confirmation email with details.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-truck text-primary"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="h6 mb-2">Order Processing</h4>
                            <p class="text-muted small">We'll notify you when your order ships.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-star text-primary"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="h6 mb-2">Review Products</h4>
                            <p class="text-muted small">Share your experience after receiving your order.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary">
                View Order Details
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary ms-3">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection
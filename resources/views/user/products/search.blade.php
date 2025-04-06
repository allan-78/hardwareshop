@extends('user.layouts.app')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Search Results</li>
        </ol>
    </nav>

    <div class="mb-4">
        <h2>Search Results for "{{ $searchQuery }}"</h2>
        <p class="text-muted">{{ $products->total() }} products found</p>
    </div>

    @if(isset($message))
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            {{ $message }}
        </div>
    @endif

    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 product-card">
                <img src="{{ $product->image_url }}" 
                     class="card-img-top" 
                     alt="{{ $product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">₱{{ number_format($product->price, 2) }}</span>
                        <a href="{{ route('products.show', $product) }}" 
                           class="btn btn-primary btn-sm">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="no-results-container">
                    <i class="bi bi-search display-1 text-muted mb-3"></i>
                    <h3 class="text-muted">No Products Found</h3>
                    <p class="text-muted mt-2">We couldn't find any products matching "{{ $searchQuery }}"</p>
                    <div class="mt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-primary me-2">
                            Browse All Products
                        </a>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                            Go Back
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>

@push('styles')
<style>
.no-results-container {
    padding: 3rem 1rem;
    background-color: #f8f9fa;
    border-radius: 0.5rem;
}
.product-card {
    transition: transform 0.2s ease-in-out;
}
.product-card:hover {
    transform: translateY(-5px);
}
</style>
@endpush
@endsection
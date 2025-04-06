@extends('user.layouts.app')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active">Categories</li>
        </ol>
    </nav>

    <h2 class="mb-4 fw-bold">Browse Categories</h2>

    <div class="row g-4">
        @foreach($categories as $category)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm category-card">
                @if($category->image_url)
                <div class="category-image-wrapper">
                    <img src="{{ $category->image_url }}" 
                         alt="{{ $category->name }}" 
                         class="card-img-top category-image">
                </div>
                @endif
                <div class="card-body">
                    <h3 class="card-title h5 fw-bold mb-3">{{ $category->name }}</h3>
                    <p class="card-text text-muted mb-3">{{ $category->description }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">{{ $category->products_count }} Products</span>
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                           class="btn btn-outline-primary btn-sm">Browse Products</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@push('styles')
<style>
.category-card {
    transition: transform 0.2s ease-in-out;
    border: none;
    border-radius: 12px;
    overflow: hidden;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}

.category-image-wrapper {
    height: 200px;
    overflow: hidden;
}

.category-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.category-card:hover .category-image {
    transform: scale(1.05);
}

.badge {
    font-size: 0.875rem;
    padding: 0.5em 1em;
}
</style>
@endpush
@endsection
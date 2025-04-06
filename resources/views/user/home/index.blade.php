@extends('user.layouts.app')

@section('content')
<div>
    <!-- Hero Section -->
    <div class="position-relative bg-dark">
        <div class="position-absolute w-100 h-100">
            <img class="w-100 h-100 object-fit-cover" src="{{ asset('images/hero.jpg') }}" alt="Hero Image">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-75"></div>
        </div>
        
        <div class="position-relative container py-5">
            <h1 class="display-4 fw-bold text-white">Quality Hardware Tools</h1>
            <p class="lead text-light mb-4">
                Find everything you need for your projects - from power tools to building materials.
                Professional grade tools at competitive prices.
            </p>
            <a href="{{ route('products.index') }}" 
               class="btn btn-primary btn-lg">
                Shop Now
            </a>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Shop by Category</h2>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-12 col-sm-6 col-lg-3">
                <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                   class="text-decoration-none">
                    <div class="card h-100">
                        <div class="category-image-container">
                            <img src="{{ $category->image_url }}" 
                                 alt="{{ $category->name }}"
                                 class="card-img-top">
                        </div>
                        <div class="card-body">
                            <h3 class="card-title h6">{{ $category->name }}</h3>
                            <p class="card-text">{{ $category->products_count }} Products</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Featured Products -->
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Featured Products</h2>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="product-image-container">
                        <img src="{{ $product->primary_image_url }}"
                             alt="{{ $product->name }}"
                             class="card-img-top">
                    </div>
                    <div class="card-body">
                        <h3 class="card-title h6">
                            <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="card-text text-muted">{{ $product->brand->name }}</p>
                        <p class="card-text fw-bold">₱{{ number_format($product->price, 2) }}</p>
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary w-100">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Search Section with Filters -->
    <div class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h2 class="text-center fw-bold mb-4">Find What You Need</h2>
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="input-group">
                                    <input type="text" name="search" 
                                           class="form-control" 
                                           placeholder="Search products..."
                                           value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select name="category" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="brand" class="form-select">
                                    <option value="">All Brands</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                                {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="price" class="form-select">
                                    <option value="">Price Range</option>
                                    <option value="0-1000" {{ request('price') == '0-1000' ? 'selected' : '' }}>
                                        Under ₱1,000
                                    </option>
                                    <option value="1000-5000" {{ request('price') == '1000-5000' ? 'selected' : '' }}>
                                        ₱1,000 - ₱5,000
                                    </option>
                                    <option value="5000-10000" {{ request('price') == '5000-10000' ? 'selected' : '' }}>
                                        ₱5,000 - ₱10,000
                                    </option>
                                    <option value="10000+" {{ request('price') == '10000+' ? 'selected' : '' }}>
                                        Over ₱10,000
                                    </option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-submit form when price range changes
    document.querySelector('select[name="price"]').addEventListener('change', function() {
        this.form.submit();
    });
</script>
@endpush
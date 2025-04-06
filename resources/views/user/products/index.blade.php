@extends('user.layouts.app')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Filters</h5>
                    <form action="{{ route('products.index') }}" method="GET">
                        <!-- Categories -->
                        <div class="mb-4">
                            <h6>Categories</h6>
                            @foreach($categories as $category)
                            <div class="form-check">
                                <input type="checkbox" name="categories[]" 
                                       value="{{ $category->id }}"
                                       id="category-{{ $category->id }}"
                                       {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                                       class="form-check-input">
                                <label class="form-check-label" for="category-{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <h6>Price Range</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" name="min_price" id="min_price"
                                           value="{{ request('min_price') }}"
                                           placeholder="Min"
                                           class="form-control form-control-sm">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price" id="max_price"
                                           value="{{ request('max_price') }}"
                                           placeholder="Max"
                                           class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Brands -->
                        <div class="mb-4">
                            <h6>Brands</h6>
                            @foreach($brands as $brand)
                            <div class="form-check">
                                <input type="checkbox" name="brands[]" 
                                       value="{{ $brand->id }}"
                                       id="brand-{{ $brand->id }}"
                                       {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}
                                       class="form-check-input">
                                <label class="form-check-label" for="brand-{{ $brand->id }}">
                                    {{ $brand->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Apply Filters
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Sort Options -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <select name="sort" 
                        onchange="window.location.href=this.value"
                        class="form-select w-auto">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}"
                            {{ request('sort') == 'newest' ? 'selected' : '' }}>
                        Newest
                    </option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}"
                            {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                        Price: Low to High
                    </option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}"
                            {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                        Price: High to Low
                    </option>
                </select>
                <small class="text-muted">
                    Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} 
                    of {{ $products->total() }} products
                </small>
            </div>

            <!-- Products -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse($products as $product)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ $product->primary_image_url }}"
                             alt="{{ $product->name }}"
                             class="card-img-top p-2" style="height: 200px; object-fit: contain;">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">
                                    {{ $product->name }}
                                </a>
                            </h5>
                            <p class="card-text text-muted small">{{ $product->brand->name }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0">₱{{ number_format($product->price, 2) }}</span>
                                <div class="d-flex align-items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $product->average_rating ? '-fill' : '' }} text-warning small"></i>
                                    @endfor
                                    <small class="text-muted ms-1">({{ number_format($product->average_rating, 1) }})</small>
                                </div>
                            </div>
                            <form action="{{ route('cart.add', ['product' => $product]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary w-100">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-box h1 text-muted"></i>
                    <p class="text-muted mt-2">No products found</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
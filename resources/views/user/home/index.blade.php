@extends('user.layouts.app')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gray-900">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="{{ asset('images/hero.jpg') }}" alt="Hero Image">
            <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                Quality Hardware Tools
            </h1>
            <p class="mt-6 text-xl text-gray-300 max-w-3xl">
                Find everything you need for your projects - from power tools to building materials.
                Professional grade tools at competitive prices.
            </p>
            <div class="mt-10">
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Shop Now
                </a>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Shop by Category</h2>
        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->id]) }}" 
               class="group">
                <div class="w-full aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden">
                    <img src="{{ $category->image_url }}" 
                         alt="{{ $category->name }}"
                         class="w-full h-full object-center object-cover group-hover:opacity-75">
                </div>
                <h3 class="mt-4 text-sm text-gray-700">{{ $category->name }}</h3>
                <p class="mt-1 text-lg font-medium text-gray-900">
                    {{ $category->products_count }} Products
                </p>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Featured Products -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Featured Products</h2>
        <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($featuredProducts as $product)
            <div class="group relative">
                <div class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75">
                    <img src="{{ $product->primary_image_url }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-center object-cover">
                </div>
                <div class="mt-4 flex justify-between">
                    <div>
                        <h3 class="text-sm text-gray-700">
                            <a href="{{ route('products.show', $product) }}">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">{{ $product->brand->name }}</p>
                    </div>
                    <p class="text-sm font-medium text-gray-900">₱{{ number_format($product->price, 2) }}</p>
                </div>
                <div class="mt-4">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Search Section with Filters -->
    <div class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-center text-2xl font-extrabold text-gray-900 mb-8">
                    Find What You Need
                </h2>
                <form action="{{ route('products.index') }}" method="GET" class="space-y-4">
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" placeholder="Search products..." 
                                   value="{{ request('search') }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                            Search
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <select name="category" class="w-full rounded-md border-gray-300">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select name="brand" class="w-full rounded-md border-gray-300">
                                <option value="">All Brands</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                            {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select name="price" class="w-full rounded-md border-gray-300">
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
@endsection

@push('scripts')
<script>
    // Price range slider functionality
    const priceRange = document.querySelector('select[name="price"]');
    priceRange.addEventListener('change', function() {
        this.form.submit();
    });
</script>
@endpush
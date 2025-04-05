@extends('user.layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                </li>
                <li>
                    <span class="text-gray-300">/</span>
                </li>
                <li>
                    <span class="text-gray-900">Products</span>
                </li>
            </ol>
        </nav>

        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-3">
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Filters</h3>
                    <form action="{{ route('products.index') }}" method="GET" class="space-y-6">
                        <!-- Categories -->
                        <div>
                            <h4 class="font-medium text-gray-900">Categories</h4>
                            <div class="mt-4 space-y-2">
                                @foreach($categories as $category)
                                <div class="flex items-center">
                                    <input type="checkbox" name="categories[]" 
                                           value="{{ $category->id }}"
                                           id="category-{{ $category->id }}"
                                           {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-100 rounded border-gray-200">
                                    <label for="category-{{ $category->id }}" 
                                           class="ml-2 text-sm text-gray-700">
                                        {{ $category->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <h4 class="font-medium text-gray-900">Price Range</h4>
                            <div class="mt-4 space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="min_price" class="sr-only">Minimum Price</label>
                                        <input type="number" name="min_price" id="min_price"
                                               value="{{ request('min_price') }}"
                                               placeholder="Min"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label for="max_price" class="sr-only">Maximum Price</label>
                                        <input type="number" name="max_price" id="max_price"
                                               value="{{ request('max_price') }}"
                                               placeholder="Max"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Brands -->
                        <div>
                            <h4 class="font-medium text-gray-900">Brands</h4>
                            <div class="mt-4 space-y-2">
                            
                                @foreach($brands as $brand)
                                <div class="flex items-center">
                                    <input type="checkbox" name="brands[]" 
                                           value="{{ $brand->id }}"
                                           id="brand-{{ $brand->id }}"
                                           {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 rounded border-gray-300">
                                    <label for="brand-{{ $brand->id }}" 
                                           class="ml-2 text-sm text-gray-700">
                                        {{ $brand->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Apply Filters
                        </button>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="mt-6 lg:mt-0 lg:col-span-9">
                <!-- Sort and View Options -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex-1 flex items-center">
                        <select name="sort" 
                                onchange="window.location.href=this.value"
                                class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                    </div>
                    <p class="text-sm text-gray-700">
                        Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} 
                        of {{ $products->total() }} products
                    </p>
                </div>

                <!-- Products -->
                <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($products as $product)
                    <div class="group relative">
                        <div class="w-full h-40 bg-gray-200 rounded-md overflow-hidden"> <!-- Reduced height to h-40 -->
                            <img src="{{ $product->primary_image_url }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-contain p-4 max-h-40"> <!-- Added max-h-40 and object-contain -->
                        </div>
                        <div class="mt-4">
                            <h3 class="text-sm text-gray-700">
                                <a href="{{ route('products.show', $product) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $product->brand->name }}</p>
                            <div class="mt-2 flex justify-between items-center">
                                <p class="text-sm font-medium text-gray-900">
                                    ₱{{ number_format($product->price, 2) }}
                                </p>
                                <div class="flex items-center">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="h-4 w-4 {{ $i <= $product->average_rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="ml-1 text-sm text-gray-500">
                                        ({{ $product->reviews_count }})
                                    </span>
                                </div>
                            </div>
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
                    @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No products found</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
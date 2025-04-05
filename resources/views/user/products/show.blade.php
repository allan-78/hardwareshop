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
                <li><span class="text-gray-300">/</span></li>
                <li>
                    <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700">Products</a>
                </li>
                <li><span class="text-gray-300">/</span></li>
                <li>
                    <span class="text-gray-900">{{ $product->name }}</span>
                </li>
            </ol>
        </nav>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-8">
            <!-- Image Gallery -->
            <div class="flex flex-col">
                <div class="aspect-w-3 aspect-h-2 rounded-lg overflow-hidden">
                    <img src="{{ $product->primary_image_url }}" 
                         alt="{{ $product->name }}"
                         id="main-image"
                         class="w-full h-full object-center object-cover">
                </div>
                
                @if($product->images->count() > 1)
                <div class="mt-4 grid grid-cols-4 gap-4">
                    @foreach($product->images as $image)
                    <button type="button" 
                            onclick="updateMainImage('{{ $image->url }}')"
                            class="relative rounded-lg overflow-hidden">
                        <img src="{{ $image->url }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-24 object-center object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $product->name }}</h1>
                
                <div class="mt-3">
                    <h2 class="sr-only">Product information</h2>
                    <p class="text-3xl text-gray-900">₱{{ number_format($product->price, 2) }}</p>
                </div>

                <!-- Rating -->
                <div class="mt-3">
                    <div class="flex items-center">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="h-5 w-5 {{ $i <= $product->average_rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="ml-2 text-sm text-gray-500">{{ $product->reviews_count }} reviews</p>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-900">Description</h3>
                    <div class="mt-4 prose prose-sm text-gray-500">
                        {!! $product->description !!}
                    </div>
                </div>

                <!-- Specifications -->
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-900">Specifications</h3>
                    <div class="mt-4">
                        <ul class="pl-4 list-disc space-y-2 text-sm text-gray-600">
                            @foreach($product->specifications as $spec)
                                <li>{{ $spec }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Add to Cart -->
                <div class="mt-8">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="flex items-center">
                            <label for="quantity" class="sr-only">Quantity</label>
                            <select name="quantity" id="quantity" 
                                    class="rounded-md border-gray-300 py-1.5 text-base leading-8 text-gray-700 focus:border-blue-500 focus:ring-blue-500">
                                @for($i = 1; $i <= min(10, $product->stock); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>

                            <button type="submit" 
                                    class="ml-4 flex-1 bg-blue-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    {{ $product->stock < 1 ? 'disabled' : '' }}>
                                {{ $product->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Stock Status -->
                <div class="mt-4">
                    <p class="text-sm text-gray-500">
                        {{ $product->stock > 0 
                            ? $product->stock . ' items in stock' 
                            : 'Currently out of stock' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-16 lg:mt-24">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Customer Reviews</h2>
            
            <div class="mt-6 lg:grid lg:grid-cols-12 lg:gap-x-8">
                <!-- Review Summary -->
                <div class="lg:col-span-4">
                    <div class="mt-3">
                        <div class="flex items-center">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="h-5 w-5 {{ $i <= $product->average_rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="ml-2 text-sm text-gray-900">
                                Based on {{ $product->reviews_count }} reviews
                            </p>
                        </div>

                        @auth
                            @if(auth()->user()->hasPurchased($product))
                                <div class="mt-6">
                                    <a href="{{ route('reviews.create', $product) }}"
                                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Write a Review
                                    </a>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Review List -->
                <div class="mt-16 lg:mt-0 lg:col-span-8">
                    <div class="space-y-8">
                        @forelse($product->reviews as $review)
                            <div class="border-t border-gray-200 pt-8">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img src="{{ $review->user->avatar_url }}" 
                                             alt="{{ $review->user->name }}"
                                             class="h-8 w-8 rounded-full">
                                        <div class="ml-4">
                                            <h4 class="text-sm font-bold text-gray-900">
                                                {{ $review->user->name }}
                                            </h4>
                                            <p class="text-sm text-gray-600">
                                                {{ $review->created_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="h-4 w-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <div class="mt-4 prose prose-sm text-gray-600">
                                    {{ $review->comment }}
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No reviews yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateMainImage(url) {
    document.getElementById('main-image').src = url;
}
</script>
@endpush
@endsection
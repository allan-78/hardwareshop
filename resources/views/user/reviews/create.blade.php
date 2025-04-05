@extends('user.layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow px-6 py-8">
            <!-- Header -->
            <div class="border-b border-gray-200 pb-6">
                <h1 class="text-2xl font-bold text-gray-900">Write a Review</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Share your experience with {{ $product->name }}
                </p>
            </div>

            <!-- Product Info -->
            <div class="py-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-24 h-24">
                        <img src="{{ $product->primary_image_url }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-full object-center object-cover rounded-lg">
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-medium text-gray-900">{{ $product->name }}</h2>
                        <p class="mt-1 text-sm text-gray-500">{{ $product->brand->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Review Form -->
            <form action="{{ route('reviews.store') }}" method="POST" class="mt-6 space-y-6">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <!-- Rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Rating</label>
                    <div class="mt-2 flex items-center space-x-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                                    data-rating="{{ $i }}"
                                    class="rating-star p-1 rounded-full hover:bg-gray-100 focus:outline-none">
                                <svg class="h-8 w-8 text-gray-300" 
                                     fill="currentColor" 
                                     viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                        @endfor
                        <input type="hidden" name="rating" id="rating" required>
                    </div>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Review Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Review Title</label>
                    <input type="text" 
                           name="title" 
                           id="title"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Review Content -->
                <div>
                    <label for="comment" class="block text-sm font-medium text-gray-700">Your Review</label>
                    <textarea name="comment" 
                              id="comment" 
                              rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              required></textarea>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('orders.show', $order) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.dataset.rating;
            ratingInput.value = rating;
            
            stars.forEach(s => {
                const starRating = s.dataset.rating;
                if (starRating <= rating) {
                    s.querySelector('svg').classList.remove('text-gray-300');
                    s.querySelector('svg').classList.add('text-yellow-400');
                } else {
                    s.querySelector('svg').classList.remove('text-yellow-400');
                    s.querySelector('svg').classList.add('text-gray-300');
                }
            });
        });
    });
});
</script>
@endpush
@endsection
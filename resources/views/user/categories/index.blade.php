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
                    <span class="text-gray-900">Categories</span>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($categories as $category)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <a href="{{ route('categories.show', $category->slug) }}" class="block">
                    @if($category->image_url)
                        <img src="{{ $category->image_url }}" 
                             alt="{{ $category->name }}" 
                             class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ $category->name }}</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            {{ $category->description }}
                        </p>
                        <p class="mt-2 text-sm text-gray-600">
                            {{ $category->products_count }} Products
                        </p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
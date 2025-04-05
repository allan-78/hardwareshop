@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h3 class="text-gray-700 text-3xl font-medium">Edit Brand: {{ $brand->name }}</h3>
        <a href="{{ route('admin.brands.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            Back to Brands
        </a>
    </div>

    <div class="mt-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <form action="{{ route('admin.brands.update', $brand) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Brand Name
                    </label>
                    <input type="text" name="name" id="name" 
                           value="{{ old('name', $brand->name) }}"
                           class="form-input w-full rounded-md shadow-sm @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="4"
                            class="form-textarea w-full rounded-md shadow-sm @error('description') border-red-500 @enderror"
                    >{{ old('description', $brand->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Update Brand
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
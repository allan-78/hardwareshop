@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h3 class="text-gray-700 text-3xl font-medium">Edit Category: {{ $category->name }}</h3>
        <a href="{{ route('admin.categories.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            Back to Categories
        </a>
    </div>

    <div class="mt-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Category Name
                    </label>
                    <input type="text" name="name" id="name" 
                           value="{{ old('name', $category->name) }}"
                           class="form-input w-full rounded-md shadow-sm @error('name') border-red-500 @enderror"
                           required>
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
                              required>{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Current Image
                    </label>
                    @if($category->image)
                        <img src="{{ Storage::url($category->image) }}" 
                             alt="{{ $category->name }}" 
                             class="h-32 w-32 object-cover rounded-lg mb-2"
                             id="preview">
                    @else
                        <p class="text-gray-500 text-sm">No image uploaded</p>
                    @endif
                </div>

                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Update Image
                    </label>
                    <input type="file" name="image" id="image"
                           class="form-input w-full @error('image') border-red-500 @enderror"
                           accept="image/*">
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Image preview functionality
    document.getElementById('image').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
        };
        reader.readAsDataURL(e.target.files[0]);
    });
</script>
@endpush
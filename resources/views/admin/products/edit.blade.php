@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h3 class="text-gray-700 text-3xl font-medium">Edit Product: {{ $product->name }}</h3>
        <a href="{{ route('admin.products.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            Back to Products
        </a>
    </div>

    <div class="mt-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Name
                        </label>
                        <input type="text" name="name" id="name" 
                               value="{{ old('name', $product->name) }}"
                               class="form-input w-full rounded-md shadow-sm @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                            SKU
                        </label>
                        <input type="text" name="sku" id="sku" 
                               value="{{ old('sku', $product->sku) }}"
                               class="form-input w-full rounded-md shadow-sm @error('sku') border-red-500 @enderror"
                               required>
                        @error('sku')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Category
                        </label>
                        <select name="category_id" id="category_id" 
                                class="form-select w-full rounded-md shadow-sm @error('category_id') border-red-500 @enderror"
                                required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Brand
                        </label>
                        <select name="brand_id" id="brand_id" 
                                class="form-select w-full rounded-md shadow-sm @error('brand_id') border-red-500 @enderror"
                                required>
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" 
                                    {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="4"
                              class="form-textarea w-full rounded-md shadow-sm @error('description') border-red-500 @enderror"
                              required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Price
                        </label>
                        <input type="number" name="price" id="price" 
                               value="{{ old('price', $product->price) }}"
                               step="0.01"
                               class="form-input w-full rounded-md shadow-sm @error('price') border-red-500 @enderror"
                               required>
                        @error('price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                            Stock
                        </label>
                        <input type="number" name="stock" id="stock" 
                               value="{{ old('stock', $product->stock) }}"
                               class="form-input w-full rounded-md shadow-sm @error('stock') border-red-500 @enderror"
                               required>
                        @error('stock')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <select name="status" id="status" 
                                class="form-select w-full rounded-md shadow-sm @error('status') border-red-500 @enderror"
                                required>
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Current Images
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($product->images as $image)
                            <div class="relative group">
                                <img src="{{ Storage::url($image->path) }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-48 object-cover rounded-lg">
                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 
                                            transition-opacity duration-200 rounded-lg flex items-center justify-center">
                                    <button type="button" 
                                            class="text-white bg-red-600 px-3 py-1 rounded-full text-sm delete-image"
                                            data-image-id="{{ $image->id }}">
                                        Remove
                                    </button>
                                </div>
                                @if($image->is_primary)
                                    <span class="absolute top-2 right-2 bg-blue-600 text-white px-2 py-1 rounded-full text-xs">
                                        Primary
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Add New Images
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="image-preview-container"></div>
                    <input type="file" name="images[]" id="images" 
                           class="form-input w-full mt-1 @error('images') border-red-500 @enderror"
                           accept="image/*"
                           multiple>
                    @error('images')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Update Product
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
    document.getElementById('images').addEventListener('change', function(e) {
        const container = document.getElementById('image-preview-container');
        container.innerHTML = '';

        Array.from(e.target.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-48 object-cover rounded-lg">
                    <span class="absolute top-2 right-2 bg-gray-800 text-white px-2 py-1 rounded-full text-xs">
                        New Image ${index + 1}
                    </span>
                `;
                container.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });

    // Delete image functionality
    document.querySelectorAll('.delete-image').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to remove this image?')) {
                const imageId = this.dataset.imageId;
                fetch(`/admin/product-images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).then(response => {
                    if (response.ok) {
                        this.closest('.relative').remove();
                    }
                });
            }
        });
    });
</script>
@endpush
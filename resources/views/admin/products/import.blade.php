@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h3 class="text-gray-700 text-3xl font-medium">Import Products</h3>
        <div class="flex space-x-4">
            <a href="{{ route('admin.products.template') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                Download Template
            </a>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                Back to Products
            </a>
        </div>
    </div>

    <div class="mt-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <!-- Instructions -->
            <div class="mb-8">
                <h4 class="text-lg font-medium text-gray-700 mb-4">Instructions</h4>
                <ul class="list-disc list-inside space-y-2 text-gray-600">
                    <li>Download the template file using the button above</li>
                    <li>Fill in the product details following the template format</li>
                    <li>Save the file in CSV format</li>
                    <li>Upload the file using the form below</li>
                    <li>Required columns: name, sku, price, stock, category_id, brand_id</li>
                    <li>Optional columns: description, status</li>
                </ul>
            </div>

            <!-- Import Form -->
            <form action="{{ route('admin.products.import.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-6">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                        Select CSV File
                    </label>
                    <input type="file" name="file" id="file" 
                           class="form-input w-full @error('file') border-red-500 @enderror"
                           accept=".csv"
                           required>
                    @error('file')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="header_row" value="1" class="form-checkbox" checked>
                        <span class="ml-2 text-sm text-gray-600">File contains header row</span>
                    </label>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Import Products
                    </button>
                </div>
            </form>

            <!-- Import History -->
            @if($imports->count() > 0)
            <div class="mt-8">
                <h4 class="text-lg font-medium text-gray-700 mb-4">Recent Imports</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">File Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Records</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Errors</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($imports as $import)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $import->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $import->filename }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $import->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($import->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($import->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $import->processed_rows }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($import->error_log)
                                        <button type="button" 
                                                class="text-blue-600 hover:text-blue-900 view-errors"
                                                data-errors="{{ $import->error_log }}">
                                            View Errors
                                        </button>
                                    @else
                                        None
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="error-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden" x-show="showModal">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Import Errors</h3>
            </div>
            <div class="px-6 py-4 max-h-96 overflow-y-auto">
                <pre id="error-content" class="text-sm text-gray-600"></pre>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                <button type="button" 
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700"
                        onclick="document.getElementById('error-modal').classList.add('hidden')">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Error modal functionality
    document.querySelectorAll('.view-errors').forEach(button => {
        button.addEventListener('click', function() {
            const errors = JSON.parse(this.dataset.errors);
            document.getElementById('error-content').textContent = JSON.stringify(errors, null, 2);
            document.getElementById('error-modal').classList.remove('hidden');
        });
    });
</script>
@endpush
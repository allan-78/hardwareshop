@extends('user.layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Account Settings</h1>
            <p class="mt-2 text-sm text-gray-600">Manage your profile information and preferences</p>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <!-- Status Message -->
            @if(session('status'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-check-circle-fill text-green-400 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 font-medium">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Profile Photo Section -->
                    <div class="lg:col-span-1 p-6 bg-gray-50 border-b lg:border-b-0 lg:border-r border-gray-200">
                        <div class="space-y-6">
                            <div class="flex flex-col items-center">
                                <div class="relative">
                                    <div class="h-40 w-40 rounded-full overflow-hidden ring-4 ring-white shadow-lg">
                                        <img id="avatar-preview" 
                                             src="{{ auth()->user()->avatar_url }}" 
                                             alt="{{ auth()->user()->name }}"
                                             class="h-full w-full object-cover">
                                    </div>
                                    <label for="avatar" 
                                           class="absolute bottom-2 right-2 bg-white rounded-full p-3 shadow-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                        <i class="bi bi-camera text-gray-600 text-xl"></i>
                                        <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden" onchange="previewImage()">
                                    </label>
                                </div>
                                <div class="mt-4 text-center">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                                    <p class="text-sm text-gray-500">Member since {{ auth()->user()->created_at->format('F Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="lg:col-span-2 p-6">
                        <div class="space-y-6">
                            <h2 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-3">Personal Information</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                                    <input type="text" name="first_name" 
                                           value="{{ old('first_name', auth()->user()->first_name) }}"
                                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition"
                                           required>
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Other input fields follow the same pattern -->
                                <!-- ... existing input fields with updated styling ... -->

                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="mt-8 space-y-6">
                            <h2 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-3">Contact Information</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Email, Phone, Address fields -->
                                <!-- ... existing fields with updated styling ... -->
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <i class="bi bi-check2 me-2"></i>
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage() {
    const input = document.getElementById('avatar');
    const preview = document.getElementById('avatar-preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
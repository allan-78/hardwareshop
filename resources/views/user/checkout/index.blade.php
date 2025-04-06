@extends('user.layouts.app')

@section('content')
<div class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" class="mt-8">
            @csrf
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">
                <!-- Shipping & Billing Information -->
                <div class="lg:col-span-8">
                    <!-- Shipping Information -->
                    <div class="bg-white rounded-lg shadow px-6 py-8">
                        <h2 class="text-lg font-medium text-gray-900 mb-6">Shipping Information</h2>
                        
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" name="first_name" id="first_name" 
                                       value="{{ old('first_name', auth()->user()->first_name) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input type="text" name="last_name" id="last_name" 
                                       value="{{ old('last_name', auth()->user()->last_name) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input type="email" name="email" id="email" 
                                       value="{{ old('email', auth()->user()->email) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="tel" name="phone" id="phone" 
                                       value="{{ old('phone', auth()->user()->phone) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="address" class="block text-sm font-medium text-gray-700">Street Address</label>
                                <input type="text" name="address" id="address" 
                                       value="{{ old('address', auth()->user()->address) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" name="city" id="city" 
                                       value="{{ old('city', auth()->user()->city) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="state" class="block text-sm font-medium text-gray-700">State/Province</label>
                                <input type="text" name="state" id="state" 
                                       value="{{ old('state', auth()->user()->state) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>
                                @error('state')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                                <input type="text" name="postal_code" id="postal_code" 
                                       value="{{ old('postal_code', auth()->user()->postal_code) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>
                                @error('postal_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>


                </div>

                <!-- Remove payment method section -->

                <!-- Order Summary -->
                <div class="mt-8 lg:mt-0 lg:col-span-4">
                    <div class="bg-white rounded-lg shadow px-6 py-8">
                        <h2 class="text-lg font-medium text-gray-900 mb-6">Order Summary</h2>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>₱{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping</span>
                                <span>₱{{ number_format($shipping, 2) }}</span>
                            </div>
                            <div class="flex justify-between border-t pt-4">
                                <span class="font-bold">Total</span>
                                <span class="font-bold">₱{{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 mt-6">
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
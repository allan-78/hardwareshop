<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', config('app.description', 'Hardware Shop - Your One-Stop Shop for Quality Hardware'))">
    <meta name="author" content="@yield('meta_author', config('app.author', 'Allan-78'))">
    <meta name="last-modified" content="{{ date('Y-m-d H:i:s') }} UTC">

    <title>{{ config('app.name', 'Hardware Shop') }} - @yield('title', 'Welcome')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Custom Header Scripts -->
    @stack('header_scripts')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div id="app">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800">
                            {{ config('app.name', 'Hardware Shop') }}
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-8">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">Home</a>
                        <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900">Products</a>
                        <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-gray-900">Categories</a>
                        
                        @auth
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-gray-600 hover:text-gray-900">
                                    <span>{{ auth()->user()->name }}</span>
                                    <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                
                                <div x-show="open" 
                                     @click.away="open = false"
                                     class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                    <div class="py-1">
                                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                        <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Orders</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Login</a>
                            <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900">Register</a>
                        @endauth
                        
                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-gray-900">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            @if(session()->has('cart') && count(session('cart')) > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full h-5 w-5 flex items-center justify-center text-xs">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center sm:hidden">
                        <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-gray-900">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50">Home</a>
                <a href="{{ route('products.index') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50">Products</a>
                <a href="{{ route('categories.index') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50">Categories</a>
            </div>
        </div>

        <!-- Page Heading -->
        @hasSection('header')
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
        @endif

        <!-- Flash Messages -->
        @if(session()->has('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 3000)"
                 class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" 
                 role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </button>
            </div>
        @endif

        @if(session()->has('error'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)"
                 class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" 
                 role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Main Content -->
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 tracking-wider uppercase">Company</h3>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="{{ route('about') }}" class="text-base text-gray-500 hover:text-gray-900">
                                    About Us
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}" class="text-base text-gray-500 hover:text-gray-900">
                                    Contact
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Legal -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 tracking-wider uppercase">Legal</h3>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="{{ route('privacy') }}" class="text-base text-gray-500 hover:text-gray-900">
                                    Privacy Policy
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('terms') }}" class="text-base text-gray-500 hover:text-gray-900">
                                    Terms of Service
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Social Links -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 tracking-wider uppercase">Social</h3>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="#" class="text-base text-gray-500 hover:text-gray-900 flex items-center">
                                    <svg class="h-6 w-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    Facebook
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-base text-gray-500 hover:text-gray-900 flex items-center">
                                    <svg class="h-6 w-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                    Twitter
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Newsletter -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 tracking-wider uppercase">Subscribe to our newsletter</h3>
                        <p class="mt-4 text-base text-gray-500">
                            Get the latest updates and promotions.
                        </p>
                        <form class="mt-4 sm:flex sm:max-w-md" action="{{ route('newsletter.subscribe') }}" method="POST">
                            @csrf
                            <input type="email" 
                                   name="email" 
                                   required 
                                   class="appearance-none min-w-0 w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-4 text-base text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:placeholder-gray-400"
                                   placeholder="Enter your email">
                            <div class="mt-3 rounded-md sm:mt-0 sm:ml-3 sm:flex-shrink-0">
                                <button type="submit" class="w-full bg-indigo-600 flex items-center justify-center border border-transparent rounded-md py-2 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Subscribe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-12 border-t border-gray-200 pt-8">
                    <p class="text-base text-gray-500 xl:text-center">
                        &copy; {{ date('Y') }} {{ config('app.name', 'Hardware Shop') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script nonce="{{ csrf_token() }}">
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'baseUrl' => url('/'),
            'currentUser' => auth()->user() ? auth()->user()->only(['id', 'name', 'email']) : null,
            'currentTime' => now()->format('Y-m-d H:i:s'),
            'timezone' => config('app.timezone')
        ]) !!};
    </script>
    
    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    
    @stack('scripts')

    <!-- Custom Page Scripts -->
    @yield('page_scripts')
</body>
</html>
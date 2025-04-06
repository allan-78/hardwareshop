<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hardware Shop') }} - @yield('title', 'Your Trusted Hardware Store')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    @if(env('APP_ENV') === 'local')
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @else
        <link href="{{ asset('build/assets/app.css') }}" rel="stylesheet">
        <script src="{{ asset('build/assets/app.js') }}" defer></script>
    @endif

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="min-vh-100 bg-light">
        @include('user.layouts.navbar')

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div class="toast show bg-success text-white" role="alert">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        @include('user.layouts.footer')
    </div>

    <!-- Remove existing scripts and replace with these in the correct order -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    <!-- Custom Scripts -->
    @if(env('APP_ENV') === 'local')
        @vite(['resources/js/app.js'])
    @else
        <script src="{{ asset('build/assets/app.js') }}" defer></script>
    @endif

    <!-- Initialize Bootstrap Components -->
    <!-- Before closing body tag -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all dropdowns
        var dropdownElements = document.querySelectorAll('.dropdown-toggle');
        dropdownElements.forEach(function(element) {
            new bootstrap.Dropdown(element);
        });
    });
    </script>

    @stack('scripts')
</body>
</html>
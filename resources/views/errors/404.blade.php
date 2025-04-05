@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-gray-700">404</h1>
        <p class="text-2xl font-medium text-gray-600 mt-4">Page Not Found</p>
        <p class="text-gray-500 mt-2">The page you're looking for doesn't exist or has been moved.</p>
        
        <div class="mt-6">
            <div class="max-w-md mx-auto">
                <form action="{{ route('search') }}" method="GET" class="mt-4">
                    <div class="flex items-center border-2 border-gray-300 rounded-lg overflow-hidden">
                        <input type="text" name="query" placeholder="Search for products..." 
                               class="w-full px-4 py-2 focus:outline-none">
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 focus:outline-none">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-6 space-x-4">
            <a href="{{ url()->previous() }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700">
                Go Back
            </a>
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                Return Home
            </a>
        </div>
    </div>
</div>
@endsection
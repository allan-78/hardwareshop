@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-gray-700">403</h1>
        <p class="text-2xl font-medium text-gray-600 mt-4">Access Forbidden</p>
        <p class="text-gray-500 mt-2">Sorry, you don't have permission to access this page.</p>
        
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
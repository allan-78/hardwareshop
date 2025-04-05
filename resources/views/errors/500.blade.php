@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-gray-700">500</h1>
        <p class="text-2xl font-medium text-gray-600 mt-4">Server Error</p>
        <p class="text-gray-500 mt-2">Oops! Something went wrong on our end.</p>
        
        @if(app()->environment('local'))
            <div class="mt-4 p-4 bg-red-50 rounded-lg max-w-2xl mx-auto">
                <p class="text-red-700 text-sm font-mono break-all">
                    {{ $exception->getMessage() }}
                </p>
            </div>
        @endif

        <div class="mt-6 space-y-4">
            <p class="text-gray-600">
                Our team has been notified and we're working to fix the issue.<br>
                Please try again later or contact support if the problem persists.
            </p>

            <div class="space-x-4">
                <a href="{{ url()->previous() }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700">
                    Go Back
                </a>
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Return Home
                </a>
                <a href="mailto:{{ config('mail.from.address') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200">
                    Contact Support
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
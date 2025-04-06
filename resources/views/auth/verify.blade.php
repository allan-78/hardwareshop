@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-700">Verify Your Email Address</h2>
            <p class="mt-2 text-sm text-gray-600">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the 
                link we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </p>
        </div>

        @if (session('resent'))
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 rounded-md p-4">
                A fresh verification link has been sent to your email address.
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-blue-600 bg-blue-50 rounded-md p-4">
                {{ session('status') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="mb-4 font-medium text-sm text-yellow-600 bg-yellow-50 rounded-md p-4">
                {{ session('warning') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div class="flex items-center justify-between">
                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 transition">
                    Resend Verification Email
                </button>
                
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                </form>
                
                <a href="#" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="text-sm text-gray-600 hover:text-gray-900">
                    Log Out
                </a>
            </div>
        </form>
    </div>
</div>

@if (app()->environment('local'))
    <div class="mt-6 w-full sm:max-w-md px-6 py-4 bg-yellow-50 text-yellow-800 shadow-md overflow-hidden sm:rounded-lg">
        <p class="text-sm">
            <strong>Development Notice:</strong> Email verification is configured to use Mailtrap. Check your Mailtrap inbox for verification emails.
        </p>
    </div>
@endif
@endsection
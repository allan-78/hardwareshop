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

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <div class="flex items-center justify-between">
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Resend Verification Email
                </button>
                
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="text-sm text-gray-600 hover:text-gray-900">
                        Log Out
                    </button>
                </form>
            </div>
        </form>

        <div class="mt-6 border-t border-gray-200 pt-4">
            <h3 class="text-lg font-medium text-gray-700 mb-2">Having trouble?</h3>
            <p class="text-sm text-gray-600">
                If you're having trouble receiving the verification email:
            </p>
            <ul class="list-disc list-inside text-sm text-gray-600 mt-2 space-y-1">
                <li>Check your spam/junk folder</li>
                <li>Make sure you entered the correct email address</li>
                <li>Try adding noreply@hardwareshop.com to your contacts</li>
                <li>Contact support if the problem persists</li>
            </ul>
        </div>
    </div>
</div>

@if(config('app.env') === 'local')
    <div class="mt-4 text-center">
        <p class="text-sm text-gray-500">
            Development Notice: Email verification link will be displayed in Laravel log file.
        </p>
    </div>
@endif
@endsection
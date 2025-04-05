@extends('user.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body p-4 text-center">
                    <h2 class="mb-4">Verify Your Email Address</h2>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success" role="alert">
                            A new verification link has been sent to your email address.
                        </div>
                    @endif

                    <p class="mb-4">
                        Thanks for signing up! Before getting started, could you verify your email address by clicking on
                        the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                    </p>

                    <div class="d-flex justify-content-between align-items-center">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Resend Verification Email
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
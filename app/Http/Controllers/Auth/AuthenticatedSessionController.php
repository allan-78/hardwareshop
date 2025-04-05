<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You need to verify your email address.',
                ])->withInput();
            }

            if ($user->status !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account has been deactivated.',
                ])->withInput();
            }

            $request->session()->regenerate();

            // Redirect based on role
            return $user->role === 'admin' 
                ? redirect()->route('admin.dashboard')
                : redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
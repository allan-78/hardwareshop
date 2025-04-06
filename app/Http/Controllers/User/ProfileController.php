<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function edit()
    {
        return view('user.profile.edit', ['user' => auth()->user()]);
    }

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();
        
        // Update user information
        $user->update($request->only([
            'first_name',
            'last_name',
            'email',
            'phone',
            'address',
            'city',
            'postal_code'
        ]));

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::delete('public/' . $user->photo);
            }

            $avatar = $request->file('avatar');
            $filename = 'avatars/avatar_' . $user->id . '_' . time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public', $filename);
            $user->photo = 'storage/' . $filename;
            $user->save();
        }

        return back()->with('status', 'Profile updated successfully!');
    }
}
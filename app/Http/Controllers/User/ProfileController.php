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

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);
        
        $user->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!'
        ]);
    }
    
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);
        
        $user = auth()->user();
        
        // Delete old photo if exists (but don't delete the default avatar)
        if ($user->photo && !str_contains($user->photo, 'default-avatar')) {
            $oldPath = str_replace('storage/', 'public/', $user->photo);
            Storage::delete($oldPath);
        }
        
        // Store new photo with unique filename
        $filename = $user->id.'_'.time().'.'.$request->file('photo')->extension();
        $path = $request->file('photo')->storeAs('public/users', $filename);
        
        $user->photo = str_replace('public/', 'storage/', $path);
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Profile photo updated successfully!',
            'photo' => $user->photo . '?t=' . time()  // Cache busting
        ]);
    }
    
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $user = auth()->user();
        $user->password = Hash::make($validated['password']);
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully!'
        ]);
    }
}
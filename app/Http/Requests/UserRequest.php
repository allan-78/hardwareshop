<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && 
            (auth()->user()->isAdmin() || auth()->id() === $this->user->id);
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->user->id)
            ],
        ];

        if ($this->hasFile('photo')) {
            $rules['photo'] = 'required|image|mimes:jpg,jpeg,png|max:2048';
        }

        if ($this->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        if (auth()->user()->isAdmin()) {
            $rules['role'] = 'sometimes|required|in:user,admin';
            $rules['status'] = 'sometimes|required|boolean';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'photo.max' => 'The photo must not exceed 2MB.',
            'photo.mimes' => 'The photo must be a JPG, JPEG or PNG file.',
            'password.min' => 'Password must be at least 8 characters.',
            'email.unique' => 'This email is already registered.'
        ];
    }
}
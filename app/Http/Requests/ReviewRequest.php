<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasVerifiedEmail();
    }

    public function rules()
    {
        return [
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:10|max:500'
        ];
    }

    public function messages()
    {
        return [
            'rating.between' => 'Rating must be between 1 and 5 stars.',
            'comment.min' => 'Review comment must be at least 10 characters.',
            'comment.max' => 'Review comment may not exceed 500 characters.'
        ];
    }
}
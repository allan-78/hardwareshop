<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ];

        if ($this->isMethod('POST')) {
            $rules['images.*'] = 'required|image|mimes:jpg,jpeg,png|max:2048';
            $rules['images'] = 'required|array|min:1';
        }

        if ($this->isMethod('PUT')) {
            $rules['images.*'] = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
            $rules['images'] = 'nullable|array';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'images.*.mimes' => 'Each image must be a file of type: jpg, jpeg, png.',
            'images.*.max' => 'Each image may not be greater than 2MB.',
            'category_id.exists' => 'The selected category is invalid.',
            'brand_id.exists' => 'The selected brand is invalid.',
        ];
    }
}
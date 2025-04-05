<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Product API
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/products/search', [ProductController::class, 'search']);

// Categories API
Route::get('/categories', [CategoryController::class, 'index']);

// Brands API
Route::get('/brands', [BrandController::class, 'index']);
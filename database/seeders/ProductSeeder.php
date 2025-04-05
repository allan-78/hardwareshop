<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $brand = Brand::first();
        $category = Category::first();

        $products = [
            [
                'name' => 'Professional Power Drill',
                'description' => 'Heavy-duty power drill for professional use',
                'price' => 199.99,
                'stock' => 50,
                'brand_id' => $brand->id,
                'category_id' => $category->id,
                'primary_image_url' => 'products/default.jpg',
                'is_featured' => true,
                'status' => 'active'
            ],
            [
                'name' => 'Premium Hammer',
                'description' => 'Professional grade hammer with ergonomic grip',
                'price' => 29.99,
                'stock' => 100,
                'brand_id' => $brand->id,
                'category_id' => $category->id,
                'primary_image_url' => 'products/default.jpg',
                'is_featured' => false,
                'status' => 'active'
            ]
        ];

        foreach ($products as $product) {
            $product['slug'] = Str::slug($product['name']);
            Product::create($product);
        }
    }
}
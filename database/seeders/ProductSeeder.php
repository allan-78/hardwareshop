<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Sample Product',
            'description' => 'Sample product description',
            'price' => 99.99,
            'stock' => 10,
            'brand_id' => 1,
            'category_id' => 1,
        ]);

        // Or use factory if you have one
        // Product::factory()->count(10)->create();

        Product::factory()
            ->count(50)
            ->create()
            ->each(function ($product) {
                // Create 3 images for each product
                for ($i = 1; $i <= 3; $i++) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => "products/default-{$i}.jpg",
                        'is_primary' => $i === 1
                    ]);
                }
            });
    }
}
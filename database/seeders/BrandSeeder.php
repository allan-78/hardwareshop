<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Stanley', 'description' => 'Quality hand tools and storage solutions'],
            ['name' => 'DeWalt', 'description' => 'Professional power tools and equipment'],
            ['name' => 'Makita', 'description' => 'Premium power tools and accessories'],
            ['name' => 'Bosch', 'description' => 'Innovative tools and hardware solutions'],
            ['name' => 'Milwaukee', 'description' => 'Heavy-duty construction tools'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
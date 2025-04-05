<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            'DeWalt',
            'Makita',
            'Bosch',
            'Stanley',
            'Milwaukee'
        ];

        foreach ($brands as $brandName) {
            Brand::create([
                'name' => $brandName,
                'slug' => Str::slug($brandName),
                'is_active' => true
            ]);
        }
    }
}
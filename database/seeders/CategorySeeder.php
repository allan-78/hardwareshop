<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Power Tools', 'description' => 'Electric and battery-powered tools'],
            ['name' => 'Hand Tools', 'description' => 'Manual tools for various tasks'],
            ['name' => 'Plumbing', 'description' => 'Pipes, fittings, and plumbing tools'],
            ['name' => 'Electrical', 'description' => 'Wiring, fixtures, and electrical supplies'],
            ['name' => 'Safety Equipment', 'description' => 'Personal protective equipment'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
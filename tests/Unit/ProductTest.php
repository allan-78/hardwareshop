<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private $product;

    protected function setUp(): void
    {
        parent::setUp();
        
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        
        $this->product = Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'price' => 100.00,
            'stock' => 10
        ]);
    }

    public function test_product_belongs_to_category()
    {
        $this->assertInstanceOf(Category::class, $this->product->category);
    }

    public function test_product_belongs_to_brand()
    {
        $this->assertInstanceOf(Brand::class, $this->product->brand);
    }

    public function test_product_has_many_reviews()
    {
        Review::factory()->count(3)->create([
            'product_id' => $this->product->id
        ]);

        $this->assertEquals(3, $this->product->reviews->count());
    }

    public function test_product_can_calculate_average_rating()
    {
        Review::factory()->count(3)->create([
            'product_id' => $this->product->id,
            'rating' => 4
        ]);

        $this->assertEquals(4.0, $this->product->average_rating);
    }

    public function test_product_can_check_if_in_stock()
    {
        $this->assertTrue($this->product->inStock());

        $this->product->update(['stock' => 0]);
        $this->assertFalse($this->product->fresh()->inStock());
    }

    public function test_product_can_be_formatted_for_currency()
    {
        $this->assertEquals('₱100.00', $this->product->formatted_price);
    }

    public function test_product_can_be_searched_by_name()
    {
        $searchProduct = Product::factory()->create([
            'name' => 'Test Product Name'
        ]);

        $results = Product::search('Test Product')->get();

        $this->assertTrue($results->contains($searchProduct));
    }

    public function test_product_can_check_if_low_stock()
    {
        $this->product->update(['stock' => 2]);
        $this->assertTrue($this->product->fresh()->lowStock());

        $this->product->update(['stock' => 20]);
        $this->assertFalse($this->product->fresh()->lowStock());
    }
}
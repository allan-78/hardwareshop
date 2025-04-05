<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private $order;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->order = Order::factory()->create([
            'user_id' => $this->user->id,
            'subtotal' => 100.00,
            'shipping_fee' => 10.00,
            'total_amount' => 110.00
        ]);
    }

    public function test_order_belongs_to_user()
    {
        $this->assertInstanceOf(User::class, $this->order->user);
    }

    public function test_order_has_many_items()
    {
        $product = Product::factory()->create();
        
        OrderItem::factory()->count(3)->create([
            'order_id' => $this->order->id,
            'product_id' => $product->id
        ]);

        $this->assertEquals(3, $this->order->items->count());
    }

    public function test_order_generates_unique_number()
    {
        $newOrder = Order::factory()->create([
            'user_id' => $this->user->id
        ]);

        $this->assertNotNull($newOrder->order_number);
        $this->assertNotEquals($this->order->order_number, $newOrder->order_number);
    }

    public function test_order_can_calculate_totals()
    {
        $product1 = Product::factory()->create(['price' => 50.00]);
        $product2 = Product::factory()->create(['price' => 75.00]);

        OrderItem::factory()->create([
            'order_id' => $this->order->id,
            'product_id' => $product1->id,
            'quantity' => 2,
            'price' => $product1->price
        ]);

        OrderItem::factory()->create([
            'order_id' => $this->order->id,
            'product_id' => $product2->id,
            'quantity' => 1,
            'price' => $product2->price
        ]);

        $this->order->calculateTotals();

        $this->assertEquals(175.00, $this->order->subtotal);
        $this->assertEquals(185.00, $this->order->total_amount);
    }

    public function test_order_can_be_cancelled()
    {
        $this->order->cancel();
        
        $this->assertEquals('cancelled', $this->order->status);
    }

    public function test_order_status_can_be_updated()
    {
        $this->order->updateStatus('processing');
        
        $this->assertEquals('processing', $this->order->status);
    }

    public function test_order_can_check_if_cancellable()
    {
        $this->assertTrue($this->order->isCancellable());

        $this->order->update(['status' => 'shipped']);
        $this->assertFalse($this->order->fresh()->isCancellable());
    }

    public function test_order_can_get_formatted_status()
    {
        $this->order->update(['status' => 'processing']);
        
        $this->assertEquals('Processing', $this->order->formatted_status);
    }
}
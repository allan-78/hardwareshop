<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_view_products()
    {
        $product = Product::factory()->create();

        $response = $this->get('/products');

        $response->assertStatus(200)
            ->assertSee($product->name);
    }

    public function test_user_can_add_to_cart()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)
            ->post('/cart/add', [
                'product_id' => $product->id,
                'quantity' => 1
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('cart_items', [
            'user_id' => $this->user->id,
            'product_id' => $product->id
        ]);
    }

    public function test_user_can_checkout()
    {
        $product = Product::factory()->create();
        
        // Add item to cart first
        $this->actingAs($this->user)
            ->post('/cart/add', [
                'product_id' => $product->id,
                'quantity' => 1
            ]);

        $checkoutData = [
            'shipping_address' => '123 Test St',
            'shipping_city' => 'Test City',
            'shipping_state' => 'Test State',
            'shipping_postal_code' => '12345',
            'payment_method' => 'cod'
        ];

        $response = $this->actingAs($this->user)
            ->post('/checkout/process', $checkoutData);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id
        ]);
    }

    public function test_user_can_view_orders()
    {
        $order = Order::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)
            ->get('/orders');

        $response->assertStatus(200)
            ->assertSee($order->order_number);
    }

    public function test_user_can_update_profile()
    {
        $updateData = [
            'first_name' => 'Updated',
            'last_name' => 'Name',
            'email' => $this->user->email,
            'phone' => '1234567890'
        ];

        $response = $this->actingAs($this->user)
            ->put('/profile', $updateData);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'first_name' => 'Updated',
            'last_name' => 'Name'
        ]);
    }
}
<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

test('customer can place an order with cash on delivery', function () {
    $user = User::factory()->create();
    $user->assignRole('customer');

    $product = Product::factory()->create([
        'price' => 49.99,
        'stock' => 10,
    ]);

    $this->actingAs($user)
        ->post(route('cart.add', $product), ['quantity' => 2])
        ->assertRedirect();

    $response = $this->actingAs($user)
        ->post(route('checkout.store'), [
            'shipping_name' => 'John Doe',
            'shipping_email' => 'john@example.com',
            'shipping_address' => '123 Main St',
            'shipping_city' => 'New York',
            'shipping_phone' => '1234567890',
            'payment_method' => 'cod',
        ]);

    $order = Order::first();

    $response->assertRedirect(route('orders.show', $order));

    expect($order)->not->toBeNull();
    expect($order->status)->toBe('pending');
    expect($order->payment_method)->toBe('cod');
    expect($order->payment_status)->toBe('pending');
    expect((float) $order->total)->toBe(99.98);

    $this->assertDatabaseHas('order_items', [
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 2,
        'price' => 49.99,
    ]);

    expect($product->fresh()->stock)->toBe(8);
    expect(session('cart'))->toBeNull();
});

test('guest can create an account and place an order with cash on delivery', function () {
    $product = Product::factory()->create([
        'price' => 25.00,
        'stock' => 5,
    ]);

    $this->post(route('cart.add', $product), ['quantity' => 1])
        ->assertRedirect();

    $response = $this->post(route('checkout.store'), [
        'shipping_name' => 'Jane Doe',
        'shipping_email' => 'jane@example.com',
        'shipping_address' => '456 Oak Ave',
        'shipping_city' => 'Los Angeles',
        'shipping_phone' => '0987654321',
        'payment_method' => 'cod',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $user = User::where('email', 'jane@example.com')->first();
    $order = Order::first();

    expect($user)->not->toBeNull();
    expect($user->hasRole('customer'))->toBeTrue();
    expect(auth()->check())->toBeTrue();

    $response->assertRedirect(route('orders.show', $order));

    expect($order)->not->toBeNull();
    expect($order->user_id)->toBe($user->id);
    expect($order->payment_method)->toBe('cod');
    expect((float) $order->total)->toBe(25.00);
});

test('guest cannot checkout with an existing email', function () {
    $existing = User::factory()->create(['email' => 'existing@example.com']);
    $existing->assignRole('customer');

    $product = Product::factory()->create(['stock' => 5]);

    $this->post(route('cart.add', $product), ['quantity' => 1]);

    $response = $this->post(route('checkout.store'), [
        'shipping_name' => 'Existing User',
        'shipping_email' => 'existing@example.com',
        'shipping_address' => '123 Main St',
        'shipping_city' => 'City',
        'shipping_phone' => '1234567890',
        'payment_method' => 'cod',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('login'));
    expect(Order::count())->toBe(0);
});

test('checkout page shows cash on delivery option for guests and registered users', function () {
    Product::factory()->create(['stock' => 5]);

    $this->post(route('cart.add', Product::first()), ['quantity' => 1])
        ->assertRedirect();

    $response = $this->get(route('checkout.index'));

    $response->assertOk();
    $response->assertSee('Cash on Delivery', false);
    $response->assertSee('Place Order', false);
    $response->assertSee('Create Your Account', false);
});

test('authenticated users do not see account creation fields at checkout', function () {
    $user = User::factory()->create();
    $user->assignRole('customer');

    Product::factory()->create(['stock' => 5]);

    $this->actingAs($user)
        ->post(route('cart.add', Product::first()), ['quantity' => 1])
        ->assertRedirect();

    $response = $this->actingAs($user)->get(route('checkout.index'));

    $response->assertOk();
    $response->assertDontSee('Create Your Account', false);
    $response->assertDontSee('password', false);
});

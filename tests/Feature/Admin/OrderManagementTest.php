<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create();
    $this->admin->assignRole('admin');
});

test('admin can update order status', function () {
    $order = Order::factory()->create(['status' => 'pending']);

    $response = $this->actingAs($this->admin)
        ->put(route('admin.orders.status', $order), ['status' => 'processing']);

    $response->assertRedirect(route('admin.orders.index'));
    expect($order->fresh()->status)->toBe('processing');
});

test('admin can update payment status', function () {
    $order = Order::factory()->create(['payment_status' => 'pending', 'payment_method' => 'cod']);

    $response = $this->actingAs($this->admin)
        ->put(route('admin.orders.payment', $order), ['payment_status' => 'paid']);

    $response->assertRedirect(route('admin.orders.show', $order));
    expect($order->fresh()->payment_status)->toBe('paid');
});

test('non admin cannot update payment status', function () {
    $customer = User::factory()->create();
    $customer->assignRole('customer');

    $order = Order::factory()->create(['payment_status' => 'pending']);

    $this->actingAs($customer)
        ->put(route('admin.orders.payment', $order), ['payment_status' => 'paid'])
        ->assertForbidden();

    expect($order->fresh()->payment_status)->toBe('pending');
});

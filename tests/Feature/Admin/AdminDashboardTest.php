<?php

use App\Models\User;

test('admin users can access the admin dashboard', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Admin Dashboard');
});

test('customer users cannot access the admin dashboard', function () {
    $customer = User::factory()->create(['role' => 'customer']);

    $response = $this->actingAs($customer)->get(route('admin.dashboard'));

    $response->assertStatus(403);
});

test('guests are redirected to login when accessing the admin dashboard', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('login'));
});

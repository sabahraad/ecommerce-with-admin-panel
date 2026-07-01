<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

test('guests can view product listing', function () {
    Product::factory()->count(3)->create();

    $response = $this->get(route('products.index'));

    $response->assertOk();
    $response->assertSee(Product::first()->name);
});

test('guests can view product details', function () {
    $product = Product::factory()->create();

    $response = $this->get(route('products.show', $product));

    $response->assertOk();
    $response->assertSee($product->name);
    $response->assertSee($product->description);
});

test('product listing can be filtered by category', function () {
    $electronics = Category::factory()->create(['name' => 'Electronics']);
    $clothing = Category::factory()->create(['name' => 'Clothing']);

    $electronicProduct = Product::factory()->create(['category_id' => $electronics->id, 'name' => 'Phone']);
    Product::factory()->create(['category_id' => $clothing->id, 'name' => 'Shirt']);

    $response = $this->get(route('products.index', ['category' => $electronics->id]));

    $response->assertOk();
    $response->assertSee($electronicProduct->name);
    $response->assertDontSee('Shirt');
});

test('product listing can be searched', function () {
    $targetProduct = Product::factory()->create(['name' => 'Unique Gadget']);
    Product::factory()->create(['name' => 'Other Item']);

    $response = $this->get(route('products.index', ['search' => 'Unique']));

    $response->assertOk();
    $response->assertSee($targetProduct->name);
    $response->assertDontSee('Other Item');
});

test('admin can create a product', function () {
    $admin = User::factory()->create()->assignRole('admin');
    $category = Category::factory()->create();

    $this->actingAs($admin)
        ->post(route('admin.products.store'), [
            'name' => 'New Product',
            'category_id' => $category->id,
            'price' => 99.99,
            'stock' => 10,
            'description' => 'A great product',
        ])
        ->assertRedirect(route('admin.products.index'));

    $this->assertDatabaseHas('products', ['name' => 'New Product']);
});

test('customer cannot access admin product create', function () {
    $customer = User::factory()->create()->assignRole('customer');

    $this->actingAs($customer)
        ->get(route('admin.products.create'))
        ->assertForbidden();
});

test('admin can create a category', function () {
    $admin = User::factory()->create()->assignRole('admin');

    $this->actingAs($admin)
        ->post(route('admin.categories.store'), [
            'name' => 'New Category',
            'description' => 'Category description',
        ])
        ->assertRedirect(route('admin.categories.index'));

    $this->assertDatabaseHas('categories', ['name' => 'New Category']);
});

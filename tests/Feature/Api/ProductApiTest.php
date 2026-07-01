<?php

use App\Models\Product;

test('api returns paginated products', function () {
    Product::factory()->count(3)->create(['is_active' => true]);

    $response = $this->getJson('/api/v1/products');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'slug', 'price', 'stock', 'image_url', 'category'],
            ],
            'links',
            'meta',
        ]);
});

test('api returns single product by slug', function () {
    $product = Product::factory()->create(['is_active' => true]);

    $response = $this->getJson("/api/v1/products/{$product->slug}");

    $response->assertOk()
        ->assertJsonPath('data.id', $product->id)
        ->assertJsonPath('data.name', $product->name);
});

test('api returns product search results', function () {
    $product = Product::factory()->create(['name' => 'Unique Gadget', 'is_active' => true]);
    Product::factory()->create(['is_active' => true]);

    $response = $this->getJson('/api/v1/products?search=Unique+Gadget');

    $response->assertOk();
    expect(count($response->json('data')))->toBe(1);
    expect($response->json('data.0.id'))->toBe($product->id);
});

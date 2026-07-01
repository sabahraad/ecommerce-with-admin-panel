<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        $price = fake()->randomFloat(2, 50, 2000);
        $hasDiscount = fake()->boolean(60);
        $oldPrice = $hasDiscount ? round($price * (1 + fake()->randomFloat(2, 0.1, 0.5)), 2) : null;
        $discountPercent = $hasDiscount && $oldPrice
            ? (int) round((($oldPrice - $price) / $oldPrice) * 100)
            : 0;

        return [
            'category_id' => Category::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'price' => $price,
            'old_price' => $oldPrice,
            'discount_percent' => $discountPercent,
            'rating' => fake()->randomFloat(1, 3, 5),
            'reviews_count' => fake()->numberBetween(10, 2000),
            'stock' => fake()->numberBetween(0, 100),
            'image' => null,
            'is_active' => true,
            'free_delivery' => fake()->boolean(70),
            'fast_delivery' => fake()->boolean(80),
            'verified' => fake()->boolean(90),
            'promo_text' => fake()->optional(0.3)->randomElement([
                'Buy 3 Get Free Delivery',
                '10% Cashback',
                'Top Deals',
            ]),
        ];
    }
}

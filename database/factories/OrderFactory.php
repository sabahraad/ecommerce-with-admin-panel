<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'status' => 'pending',
            'total' => fake()->randomFloat(2, 10, 500),
            'shipping_name' => fake()->name(),
            'shipping_email' => fake()->safeEmail(),
            'shipping_address' => fake()->address(),
            'shipping_city' => fake()->city(),
            'shipping_phone' => fake()->phoneNumber(),
            'payment_status' => 'pending',
            'payment_method' => 'cod',
        ];
    }
}

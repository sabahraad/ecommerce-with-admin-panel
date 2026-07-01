<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Grocery' => [
                ['Rupchanda Soyabean Oil - 1L', 199, 190, 14, 5.0, 79],
                ['Chashi Aromatic Chinigura Rice - 1kg', 164, 190, 14, 5.0, 248],
                ['GoodKnight Liquid Mosquito Repellent', 104, 130, 20, 5.0, 249],
                ['Rupchanda Chinigura Rice - 2kg', 159, 195, 18, 4.9, 465],
                ['Mr White Detergent Powder - 1kg', 99, 200, 51, 4.9, 192],
                ['Surf Excel Matic Liquid - Top Load 1L', 247, 400, 38, 4.9, 124],
                ['Aroma Air Freshener Divine Lime 300ML', 125, 300, 58, 4.8, 88],
                ['Starship Full Cream Milk Powder - 1kg', 725, 770, 6, 4.9, 296],
                ['Aroma Air Freshener Orange Crush 300ML', 125, 300, 58, 4.9, 111],
                ['Aroma Air Freshener Fresh Aura 300ML', 123, 300, 59, 4.8, 97],
                ['Hoco EQ34 Plus Rima ANC Earbuds', 729, 2000, 64, 5.0, 65],
                ['Fresh Refined Sugar - 1kg', 109, 110, 1, 4.9, 1035],
            ],
            'Electronics' => [
                ['Wireless Headphones', 1999, 2500, 20, 4.7, 342],
                ['Smart Watch', 2499, 3200, 22, 4.5, 210],
                ['Bluetooth Speaker', 799, 1200, 33, 4.6, 156],
            ],
            'Clothing' => [
                ['Cotton T-Shirt', 299, 450, 34, 4.3, 89],
                ['Denim Jacket', 899, 1400, 36, 4.5, 67],
                ['Running Shoes', 1199, 1800, 33, 4.4, 124],
            ],
            'Home & Living' => [
                ['Ceramic Coffee Mug', 149, 250, 40, 4.6, 432],
                ['Throw Pillow', 249, 400, 38, 4.5, 112],
                ['LED Desk Lamp', 459, 700, 34, 4.7, 98],
            ],
        ];

        foreach ($categories as $categoryName => $products) {
            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'description' => "Browse our {$categoryName} collection.",
            ]);

            foreach ($products as $index => $data) {
                [$name, $price, $oldPrice, $discount, $rating, $reviews] = $data;
                Product::create([
                    'category_id' => $category->id,
                    'name' => $name,
                    'slug' => Str::slug($name) . '-' . $index,
                    'description' => fake()->sentence(12),
                    'price' => $price,
                    'old_price' => $oldPrice,
                    'discount_percent' => $discount,
                    'rating' => $rating,
                    'reviews_count' => $reviews,
                    'stock' => fake()->numberBetween(20, 200),
                    'image' => null,
                    'is_active' => true,
                    'free_delivery' => true,
                    'fast_delivery' => true,
                    'verified' => true,
                    'promo_text' => $index % 3 === 0 ? 'Buy 3 Get Free Delivery' : ($index % 5 === 0 ? '10% Cashback' : null),
                ]);
            }
        }
    }
}

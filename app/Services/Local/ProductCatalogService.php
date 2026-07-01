<?php

namespace App\Services\Local;

use App\Models\Category;
use App\Models\Product;
use App\Services\Contracts\ProductCatalogInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductCatalogService implements ProductCatalogInterface
{
    public function listProducts(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = Product::with('category')->where('is_active', true);

        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function findProduct(string $slug): ?Product
    {
        return Product::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();
    }

    public function listCategories(): Collection
    {
        return Category::orderBy('name')->get();
    }

    public function relatedProducts($product, int $limit = 4): Collection
    {
        return Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->latest()
            ->take($limit)
            ->get();
    }
}

<?php

namespace App\Services\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProductCatalogInterface
{
    /**
     * List active products with optional filters.
     *
     * @param array<string, mixed> $filters
     */
    public function listProducts(array $filters = [], int $perPage = 12): LengthAwarePaginator;

    /**
     * Find a single active product by slug.
     */
    public function findProduct(string $slug): ?object;

    /**
     * List all categories.
     */
    public function listCategories(): Collection;

    /**
     * Get related products for a given product.
     *
     * @param mixed $product
     */
    public function relatedProducts($product, int $limit = 4): Collection;
}

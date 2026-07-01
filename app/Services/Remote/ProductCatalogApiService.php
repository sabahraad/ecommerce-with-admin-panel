<?php

namespace App\Services\Remote;

use App\Services\Contracts\ProductCatalogInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Remote API-backed catalog service.
 *
 * This is a placeholder implementation. When a real product API is available,
 * configure STOREFRONT_API_BASE_URL and this service will call it.
 * Until then it returns empty/fallback data so the storefront degrades gracefully.
 */
class ProductCatalogApiService implements ProductCatalogInterface
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.storefront.api_base_url', ''), '/');
    }

    public function listProducts(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        if (empty($this->baseUrl)) {
            return new Paginator(collect(), 0, $perPage);
        }

        try {
            $response = Http::timeout(5)
                ->get("{$this->baseUrl}/products", array_merge($filters, ['per_page' => $perPage]));

            if ($response->successful()) {
                $data = $response->json();
                $items = collect($data['data'] ?? []);
                $total = $data['meta']['total'] ?? $items->count();

                return new Paginator($items, $total, $perPage);
            }
        } catch (\Throwable $e) {
            Log::warning('Storefront API listProducts failed: ' . $e->getMessage());
        }

        return new Paginator(collect(), 0, $perPage);
    }

    public function findProduct(string $slug): ?object
    {
        if (empty($this->baseUrl)) {
            return null;
        }

        try {
            $response = Http::timeout(5)->get("{$this->baseUrl}/products/{$slug}");

            if ($response->successful()) {
                return (object) $response->json('data');
            }
        } catch (\Throwable $e) {
            Log::warning('Storefront API findProduct failed: ' . $e->getMessage());
        }

        return null;
    }

    public function listCategories(): Collection
    {
        if (empty($this->baseUrl)) {
            return collect();
        }

        try {
            $response = Http::timeout(5)->get("{$this->baseUrl}/categories");

            if ($response->successful()) {
                return collect($response->json('data'));
            }
        } catch (\Throwable $e) {
            Log::warning('Storefront API listCategories failed: ' . $e->getMessage());
        }

        return collect();
    }

    public function relatedProducts($product, int $limit = 4): Collection
    {
        if (empty($this->baseUrl)) {
            return collect();
        }

        try {
            $slug = is_object($product) && property_exists($product, 'slug') ? $product->slug : $product;
            $response = Http::timeout(5)->get("{$this->baseUrl}/products/{$slug}/related", ['limit' => $limit]);

            if ($response->successful()) {
                return collect($response->json('data'));
            }
        } catch (\Throwable $e) {
            Log::warning('Storefront API relatedProducts failed: ' . $e->getMessage());
        }

        return collect();
    }
}

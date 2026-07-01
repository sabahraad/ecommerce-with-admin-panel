<?php

namespace App\Providers;

use App\Services\Contracts\ProductCatalogInterface;
use App\Services\Local\ProductCatalogService;
use App\Services\Remote\ProductCatalogApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductCatalogInterface::class, function () {
            $source = config('services.storefront.data_source', 'local');

            return $source === 'api'
                ? new ProductCatalogApiService()
                : new ProductCatalogService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

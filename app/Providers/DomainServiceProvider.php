<?php

namespace App\Providers;

use Domain\Auth\Providers\AuthServiceProvider;
use Domain\Catalog\Providers\CatalogServiceProvider;
use Domain\Product\Providers\ProductServiceProvider;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->register(
            \Domain\Order\Providers\OrderServiceProvider::class
        );

        $this->app->register(
            \Domain\Cart\Providers\CartServiceProvider::class
        );

        $this->app->register(
            AuthServiceProvider::class
        );

        $this->app->register(
            CatalogServiceProvider::class
        );

        $this->app->register(
            ProductServiceProvider::class
        );
    }
}

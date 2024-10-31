<?php

namespace Domain\Catalog\Providers;


use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->register(ActionServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}

<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->group(base_path('routes/auth.php'));

            Route::middleware('web')
                ->group(base_path('routes/catalog.php'));

            Route::middleware('web')
                ->group(base_path('routes/product.php'));

            Route::middleware('web')
                ->group(base_path('routes/cart.php'));

            Route::middleware('web')
                ->group(base_path('routes/order.php'));
        },
        commands: __DIR__.'/../routes/console.php',
        health: '/up',

    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (DomainException $e) {
            flash()->alert($e->getMessage());

            return session()->previousUrl()
                ? back()
                : redirect()->route('home');
        });
    })
    ->create();

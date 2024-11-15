<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\CatalogViewMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(OrderController::class)->prefix('order')->group(function () {
    Route::get('/', 'index')->name('order');
    Route::post('/', 'handle')->name('order.handle');
});
Route::get('/order/', [OrderController::class, 'index'])
    ->name('order');

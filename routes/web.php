<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThumbnailController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/', HomeController::class)->name('home');

    Route::get('/storage/images/{dir}/{method}/{size}/{file}', ThumbnailController::class)
        ->where('method', 'resize|crop|fit')
        ->where('size', '\d+x\d+')
        ->where('file', '.+\.(png|jpg|jpeg|gif|bmp)$')
        ->name('thumbnail');
});

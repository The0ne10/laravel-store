<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/', HomeController::class)->name('home');
});

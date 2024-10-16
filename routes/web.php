<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', HomeController::class)->name('home');

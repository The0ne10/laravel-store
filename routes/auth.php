<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::get('/sign-up', 'signUp')->name('signUp');

    Route::post('/sign-in', 'signIn')->name('signIn');
    Route::post('/sign-up', 'register')->name('register');

    Route::delete('/logout', 'logOut')->name('logOut');
});

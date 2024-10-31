<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use Illuminate\Support\Facades\Route;

Route::controller(SignInController::class)->group(function () {
    Route::get('/login', 'page')->name('login');
    Route::post('/login', 'handle')->name('login.handle');
    Route::delete('/logout', 'logOut')->name('logOut');
});

Route::controller(SignUpController::class)->group(function () {
    Route::get('/sign-up', 'page')->name('register');
    Route::post('/sign-up', 'handle')->name('register.handle');
});

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot-password', 'page')->name('forgot');
    Route::post('/forgot-password', 'handle')->name('forgot.handle');
})->middleware('guest');

Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('/reset-password/{token}', 'page')->name('password.reset');
    Route::post('/reset-password', 'handle')->name('password-reset.handle');
})->middleware('guest');

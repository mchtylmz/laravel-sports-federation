<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('auth', [\App\Http\Controllers\AuthController::class, 'auth'])->name('auth');
});

Route::middleware('auth')->group(function () {

    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

});

<?php

use Illuminate\Support\Facades\Route;

Route::get('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {

    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

});

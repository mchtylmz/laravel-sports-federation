<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Models\Federation;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('auth', [AuthController::class, 'auth'])->name('auth');
});

Route::middleware('auth')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::name('events.')
        ->prefix('events')
        ->middleware('role:admin,manager')
        ->controller(\App\Http\Controllers\EventController::class)
        ->group(function () {
            Route::get('', 'index')->name('index');
        });

    Route::name('settings.')
        ->prefix('settings')
        ->middleware('role:superadmin')
        ->controller(\App\Http\Controllers\SettingController::class)
        ->group(function () {
            Route::get('index', 'index')->name('index');
            Route::post('save', 'save')->name('save');

            Route::get('federation', 'federation')->name('federation');
            Route::get('federation/detail/{federation:id?}', 'federationDetail')->name('federation.show');
            Route::post('federation/save/{federation:id?}', 'federationSave')->name('federation.save');
            Route::post('federation/delete/{federation:id?}', 'federationDelete')->name('federation.delete');
        });

    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile/password', [AuthController::class, 'changePassword'])->name('profile.password');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

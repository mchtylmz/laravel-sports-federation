<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Models\Federation;
use App\Models\Event;
use App\Enums\UserType;
use App\Models\User;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('auth', [AuthController::class, 'auth'])->name('auth');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile/password', [AuthController::class, 'changePassword'])->name('profile.password');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // middleware
    Route::name('user.')
        ->prefix('users')
        ->middleware('role:superadmin')
        ->controller(\App\Http\Controllers\UserController::class)
        ->group(function () {
            Route::get('{usertype}', 'index')->name('index');
            Route::get('{usertype}/json', 'json')->name('json');
            Route::get('{usertype}/detail/{user:id?}', 'detail')->name('show');
            Route::post('{usertype}/save/{user:id?}', 'save')->name('save');
        });

    // middleware
    Route::name('event.')
        ->prefix('events')
        ->middleware('role:admin,manager')
        ->controller(\App\Http\Controllers\EventController::class)
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('json', 'json')->name('json');
            Route::get('detail/{event:id?}', 'detail')->name('show');
            Route::post('save/{event:id?}', 'save')->name('save');
            Route::post('delete/{event:id?}', 'delete')->name('delete');
        });

    // middleware
    Route::name('federation.')
        ->prefix('federations')
        ->middleware('role:superadmin,admin')
        ->controller(\App\Http\Controllers\FederationController::class)
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('json', 'json')->name('json');
            Route::get('detail/{federation:id?}', 'detail')->name('show');
            Route::post('save/{federation:id?}', 'save')->name('save');
            Route::post('delete/{federation:id?}', 'delete')->name('delete');
        });

    // middleware
    Route::name('settings.')
        ->prefix('settings')
        ->middleware('role:superadmin')
        ->controller(\App\Http\Controllers\SettingController::class)
        ->group(function () {
            Route::get('index', 'index')->name('index');
            Route::post('save', 'save')->name('save');
        });
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Models\Federation;
use App\Models\Event;
use App\Enums\UserType;
use App\Models\User;
use App\Models\Club;
use App\Models\Punishment;
use App\Models\People;
use App\Models\Director;
use App\Models\Log;
use App\Models\Note;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('auth', [AuthController::class, 'auth'])->name('auth');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('calendar', [HomeController::class, 'calendar'])->name('calendar');
    Route::get('my-notes', [HomeController::class, 'myNotes'])->name('my.notes');

    Route::get('profile', [AuthController::class, 'profile'])->name('profile');

    Route::post('profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile/password', [AuthController::class, 'changePassword'])->name('profile.password');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // middleware
    Route::name('log.')
        ->prefix('logs')
        ->middleware('role:superadmin')
        ->controller(\App\Http\Controllers\LogController::class)
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('json', 'json')->name('json');
            Route::get('detail/{log:id?}', 'detail')->name('show');
        });

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
            Route::post('delete/{user:id}', 'delete')->name('delete');
        });

    // middleware
    Route::name('event.')
        ->prefix('events')
        ->middleware('role:admin,manager,calendar')
        ->controller(\App\Http\Controllers\EventController::class)
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('json', 'json')->name('json');
            Route::get('export/excel', 'exportExcel')->name('export.excel');
            Route::get('export/pdf', 'exportPdf')->name('export.pdf');
            Route::post('save/{event:id?}', 'save')->name('save');
            Route::post('delete/{event:id}', 'delete')->name('delete');
        });

    Route::name('event.')
        ->prefix('events')
        ->controller(\App\Http\Controllers\EventController::class)
        ->group(function () {
            Route::get('calendar', 'calendar')->name('calendar');
            Route::middleware('role:superadmin,admin,manager,calendar')
                ->get('detail/{event:id?}', 'detail')
                ->name('show');
        });


    // middleware
    Route::name('club.')
        ->prefix('clubs')
        ->middleware('role:superadmin,admin')
        ->controller(\App\Http\Controllers\ClubController::class)
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('json', 'json')->name('json');
            Route::get('detail/{club:id?}', 'detail')->name('show');
            Route::middleware('role:superadmin')->post('save/{club:id?}', 'save')->name('save');
            Route::middleware('role:superadmin')->post('delete/{club:id}', 'delete')->name('delete');
        });

    // middleware
    Route::name('punishment.')
        ->prefix('punishments')
        ->middleware('role:superadmin,admin')
        ->controller(\App\Http\Controllers\PunishmentController::class)
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('json', 'json')->name('json');
            Route::get('detail/{punishment:id?}', 'detail')->name('show');
            Route::post('save/{punishment:id?}', 'save')->name('save');
            Route::post('delete/{punishment:id}', 'delete')->name('delete');
        });

    // middleware
    Route::name('people.')
        ->prefix('peoples')
        ->middleware('role:superadmin,admin')
        ->controller(\App\Http\Controllers\PeopleController::class)
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('json', 'json')->name('json');
            Route::get('detail/{people:id?}', 'detail')->name('show');
            Route::post('save/{people:id?}', 'save')->name('save');
            Route::post('delete/{people:id}', 'delete')->name('delete');
        });

    // middleware
    Route::name('federation.')
        ->prefix('federations')
        ->middleware('role:superadmin,admin')
        ->group(function () {

            Route::middleware('role:superadmin')
                ->controller(\App\Http\Controllers\FederationController::class)
                ->group(function () {
                    Route::get('', 'index')->name('index');
                    Route::get('json', 'json')->name('json');
                    Route::get('detail/{federation:id?}', 'detail')->name('show');
                    Route::post('save/{federation:id?}', 'save')->name('save');
                    Route::post('delete/{federation:id}', 'delete')->name('delete');
                    Route::get('notes/{federation:id}', 'notes')->name('notes');
                    Route::post('notes/save/{federation:id}', 'noteSave')->name('notes.save');
                    Route::post('notes/delete/{note:id}', 'noteDelete')->name('notes.delete');
                });

            Route::middleware('role:admin')
                ->controller(\App\Http\Controllers\FederationInfoController::class)
                ->name('info.')
                ->prefix('info')
                ->group(function () {
                    Route::get('directories', 'directories')->name('directories');
                    Route::post('directories/delete/{director:id}', 'directorDelete')->name('director.delete');
                    Route::post('directories/save/{director:id?}', 'directorSave')->name('director.save');

                    Route::get('statute', 'statute')->name('statute');
                    Route::post('statute/save/{federation:id}', 'statuteSave')->name('statute.save');

                    Route::get('clubs', 'clubs')->name('clubs');

                    Route::get('date', 'date')->name('date');
                    Route::post('date/save/{federation:id}', 'dateSave')->name('date.save');

                    Route::get('contact', 'contact')->name('contact');
                    Route::post('contact/save/{federation:id}', 'contactSave')->name('contact.save');

                    Route::get('members', 'members')->name('members');
                    Route::post('members/save/{federation:id}', 'membersSave')->name('members.save');
                });

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

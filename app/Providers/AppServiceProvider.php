<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Facades\View::composer('*', function (View $view) {
            $view->with('site_title', settings()->site_title ?? config('app.name'));
            $view->with('site_logo', settings()->site_logo ?? 'uploads/logo.png');
            $view->with('site_favicon', settings()->site_favicon ?? 'uploads/logo.png');
        });
    }
}

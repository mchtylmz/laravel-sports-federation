<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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
        Request::macro('paginate', function () {
            $limit = request()->get('limit', 15);
            $offset = request()->get('offset', 0);

            return intval($offset / $limit) + 1;
        });

        Builder::macro('page', function () {
            $limit = request()->get('limit', 15);
            $offset = request()->get('offset', 0);

            return $this->take($limit)->skip($offset)->get();
        });
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

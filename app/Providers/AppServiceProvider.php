<?php

namespace App\Providers;

use App\Enums\Status;
use App\Models\People;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
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
            $note_count = 0;
            if (auth()->check()) {
                $note_count = cache()->remember(
                    sprintf('user_note_count_%d', auth()->id()),
                    86400,
                    function () {
                        return user()->federation()?->notes()->where('is_read', 0)->count();
                    }
                );
            }
            
            $people_count = People::where('status', Status::pending);
            if (auth()->check() && hasRole('admin')) {
                $people_count->where('federation_id', auth()->user()->federation()?->id);
            }

            $view->with('site_title', settings()->site_title ?? config('app.name'));
            $view->with('header_under_text', settings()->header_under_text ?? false);
            $view->with('site_logo', settings()->site_logo ?? 'uploads/logo.png');
            $view->with('site_favicon', settings()->site_favicon ?? 'uploads/logo.png');
            $view->with('note_count', $note_count);
            $view->with('people_wait_count', $people_count->count());
        });

        Carbon::setlocale(app()->getLocale());

        Paginator::useBootstrapFive();
    }
}

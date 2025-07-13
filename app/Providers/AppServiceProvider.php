<?php

namespace App\Providers;

use App\Models\Audition;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        //
        Schema::defaultStringLength(191);

        View::composer('components.layouts.app.land', function ($view) {
            $audition = Cache::remember('audition', now()->addHours(1), function () {
                return Audition::query()->where('active', true)->orderBy('created_at', 'desc')->first();
            });

            $view->with('audition', $audition);
        });
    }
}

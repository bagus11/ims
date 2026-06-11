<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
   public function boot(): void
    {
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
            \URL::forceRootUrl(config('app.url'));
        }
    }
}

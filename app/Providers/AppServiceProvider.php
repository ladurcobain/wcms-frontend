<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helpers/Curl.php';
        require_once app_path() . '/Helpers/Status.php';
        require_once app_path() . '/Helpers/Module.php';
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Paginator::useBootstrap();
        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
    }
}

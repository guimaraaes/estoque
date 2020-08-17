<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\ProductRepositoryInterface', 'App\Repositories\Eloquent\ProductRepository');
        $this->app->bind('App\Repositories\SaleRepositoryInterface', 'App\Repositories\Eloquent\SaleRepository');
        $this->app->bind('App\Repositories\UserRepositoryInterface', 'App\Repositories\Eloquent\UserRepository');
        $this->app->bind('App\Repositories\ReportRepositoryInterface', 'App\Repositories\Eloquent\ReportRepository');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       // Schema::defaultStringLength(191);
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SaleRepositoryInterface; 
use App\Repositories\Eloquent\SaleRepository; 

class SaleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

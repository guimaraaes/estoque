<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ReportRepositoryInterface; 
use App\Repositories\Eloquent\ReportRepository; 

class ReportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
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

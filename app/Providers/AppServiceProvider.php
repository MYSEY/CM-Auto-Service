<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
       // កំណត់ឲ្យ Laravel ប្រើ Pagination Style របស់ Bootstrap 5
        Paginator::useBootstrapFive();
    }
}

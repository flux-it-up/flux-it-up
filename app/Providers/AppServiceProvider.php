<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SkuService;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SkuService::class, function($app) {
            return new SkuService();
        });
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}

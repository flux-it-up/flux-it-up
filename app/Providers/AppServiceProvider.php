<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Livewire\Admin\Services\SkuService;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Illuminate\Support\Facades\Blade;

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

        Blade::component('layouts.site', 'site');

        Livewire::component('admin.service.index', \App\Livewire\Admin\Service\Index::class);
        Livewire::component('admin.service.update', \App\Livewire\Admin\Service\Update::class);
        Livewire::component('admin.service.delete', \App\Livewire\Admin\Service\Delete::class);
    }
}

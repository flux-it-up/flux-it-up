<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use App\Models\ProductCategory;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        
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

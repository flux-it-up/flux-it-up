<?php

use App\Livewire\User\UpdateProfile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Users\Index as UsersIndex;
use App\Livewire\User\Index as UserIndex;
use App\Livewire\Console\Index as ConsoleIndex;
use App\Livewire\Service\Index as ServiceIndex;
use App\Livewire\PricingTier\Index as PricingTierIndex;
use App\Livewire\Product\Index as ProductIndex;
use App\Livewire\Product\ManageImages as ProductImages;
use App\Livewire\Order\Index as OrderIndex;
use App\Livewire\RepairRequest\Index as RepairIndex;

Route::view('/', 'livewire.home')->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/user', UserIndex::class)->name('user.index');

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/users', UsersIndex::class)->name('users.index');

    Route::get('/consoles', ConsoleIndex::class)->name('consoles.index');

    Route::get('/services', ServiceIndex::class)->name('services.index');

    Route::get('/pricingtiers', PricingTierIndex::class)->name('pricing-tiers.index');

    Route::get('/products', ProductIndex::class)->name('products.index');

    Route::get('/product/images/{product}', ProductImages::class)->name('product.images');

    Route::get('/orders', OrderIndex::class)->name('orders.index');

    Route::get('/repair-requests', RepairIndex::class)->name('repairs.index');
});

require __DIR__.'/auth.php';

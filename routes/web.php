<?php

use App\Livewire\User\UpdateProfile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Admin\Users\Index as UsersIndex;
use App\Livewire\Customer\Profile\Index as Profile;
use App\Livewire\Admin\Console\Index as ConsoleIndex;
use App\Livewire\Admin\Service\Index as ServiceIndex;
use App\Livewire\Admin\PricingTier\Index as PricingTierIndex;
use App\Livewire\Admin\Product\Index as ProductIndex;
use App\Livewire\Admin\Product\ManageImages as ProductImages;
use App\Livewire\Admin\Order\Index as OrderIndex;
use App\Livewire\Admin\RepairRequest\Index as RepairIndex;
use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\About;
use App\Livewire\Frontend\Services;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', Profile::class)->name('profile.index');

    Route::prefix('admin')->group(function () {

        Route::get('/dashboard', Dashboard::class)->name('dashboard')->middleware(['can:view dashboard']);
        Route::get('/users', UsersIndex::class)->name('users.index')->middleware(['can:view users']);
        Route::get('/consoles', ConsoleIndex::class)->name('consoles.index')->middleware(['can:manage site']);
        Route::get('/repairservices', ServiceIndex::class)->name('services.index')->middleware(['can:manage site']);
        Route::get('/pricingtiers', PricingTierIndex::class)->name('pricing-tiers.index')->middleware(['can:manage site']);
        Route::get('/products', ProductIndex::class)->name('products.index')->middleware(['can:manage site']);
        Route::get('/product/images/{product}', ProductImages::class)->name('product.images')->middleware(['can:manage site']);
        Route::get('/orders', OrderIndex::class)->name('orders.index')->middleware(['can:view dashboard']);
        Route::get('/repair-requests', RepairIndex::class)->name('repairs.index')->middleware(['can:view dashboard']);
    });
});

Route::get('/', Home::class)->name('welcome');
Route::get('/about', About::class)->name('about');
Route::get('/services', Services::class)->name('services');

require __DIR__.'/auth.php';

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
use App\Livewire\Admin\Inventory\Index as InventoryIndex;
use App\Livewire\Admin\Order\Index as OrderIndex;
use App\Livewire\Admin\RepairRequest\Index as RepairIndex;
use App\Livewire\Admin\TaxRates\State as StateIndex;
use App\Livewire\Admin\TaxRates\County as CountyIndex;
use App\Livewire\Admin\TaxRates\City as CityIndex;
use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\About;
use App\Livewire\Frontend\Services;
use App\Livewire\Frontend\Products\Index as ProductsIndex;
use App\Livewire\Frontend\Products\CategoryPage as ProductsCategory;
use App\Livewire\Frontend\Products\ProductPage;


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', Profile::class)->name('profile.index');

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::prefix('users')->group(function() {
            Route::get('/', UsersIndex::class)->name('users.index');
        });
        Route::prefix('taxrates')->group(function() {
            Route::get('/', StateIndex::class)->name('taxrates.state');
            Route::prefix('{state:id}')->group(function() {
                Route::get('/', CountyIndex::class)->name('taxrates.county');
                Route::get('/{county:id}', CityIndex::class)->name('taxrates.city');
            });
        });
        Route::prefix('consoles')->group(function() {
            Route::get('/', ConsoleIndex::class)->name('consoles.index');
        });
        Route::prefix('repairservices')->group(function() {
            Route::get('/', ServiceIndex::class)->name('services.index');
        });
        Route::prefix('pricingtiers')->group(function() {
            Route::get('/', PricingTierIndex::class)->name('pricing-tiers.index');
        });
        Route::prefix('inventory')->group(function() {
            Route::prefix('products')->group(function() {
                Route::get('/', ProductIndex::class)->name('products.index');
                Route::get('/images/{product}', ProductImages::class)->name('product.images');
            });
            Route::prefix('adjustments')->group(function() {
                Route::get('/', InventoryIndex::class)->name('adjustments.index');
            });
        });
        Route::prefix('orders')->group(function() {
            Route::get('/', OrderIndex::class)->name('orders.index');
        });
        Route::prefix('repairs')->group(function() {
            Route::get('/', RepairIndex::class)->name('repairs.index');
        });
        
    });
});

Route::get('/', Home::class)->name('welcome');
Route::get('/about', About::class)->name('about');
Route::get('/services', Services::class)->name('services');
Route::prefix('products')->group(function() {
    Route::get('/', ProductsIndex::class)->name('products');
    Route::prefix('{category:slug}')->group(function() {
        Route::get('/', ProductsCategory::class)->name('products.category');
        Route::get('/{product:slug}', ProductPage::class)->name('products.show');
    });
});


require __DIR__.'/auth.php';

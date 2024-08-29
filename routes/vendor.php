<?php

use App\Http\Controllers\Api\Agent\SettingController;
use App\Http\Controllers\Vendor\AdvertisingController;
use App\Http\Controllers\Vendor\CatalogueController;
use App\Http\Controllers\Vendor\DashboardController;
use App\Http\Controllers\Vendor\InventoryController;
use App\Http\Controllers\Vendor\OnboardingController;
use App\Http\Controllers\Vendor\OrderController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\SettingController as VendorSettingController;
use App\Http\Controllers\Vendor\StockController;
use Illuminate\Support\Facades\Route;


// Route::namespace('Vendor')->as('vendor.')->middleware(['auth'])->group(function () {
// });

// Route::get('/registration', function () {
//     return view('vendor.pages.registration');
// })->name('vendor.registration');

Route::controller(OnboardingController::class)->group(function () {
    Route::match(['get', 'post'], '/registration', 'addVendor')->name('vendor.registration');
});

Route::namespace('Vendor')->as('vendor.')->middleware([])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::match(['get', 'post'], '/ ', 'index')->name('dashboard');
    });
    Route::controller(CatalogueController::class)->group(function () {
        Route::match(['get', 'post'], '/catalogue', 'createCatalogue')->name('catalogue');
    });
    Route::controller(InventoryController::class)->group(function () {
        Route::match(['get', 'post'], '/inventory', 'createInventory')->name('inventory');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::match(['get', 'post'], '/orders', 'index')->name('orders');
    });
    Route::controller(AdvertisingController::class)->group(function () {
        Route::match(['get', 'post'], '/advertising', 'createAdOne')->name('advertising');
        Route::match(['get', 'post'], '/advertising2', 'createAdTwo')->name('advertising2');
        Route::match(['get', 'post'], '/advertising3', 'createAdThree')->name('advertising3');
    });
    Route::controller(VendorSettingController::class)->group(function () {
        Route::match(['get', 'post'], '/settings', 'index')->name('settings');
    });
});

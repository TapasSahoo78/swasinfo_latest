<?php

use App\Http\Controllers\Api\Agent\SettingController;
use App\Http\Controllers\Vendor\AdvertisingController;
use App\Http\Controllers\Vendor\CatalogueController;
use App\Http\Controllers\Vendor\DashboardController;
use App\Http\Controllers\Vendor\InventoryController;
use App\Http\Controllers\Vendor\OrderController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\SettingController as VendorSettingController;
use App\Http\Controllers\Vendor\StockController;
use Illuminate\Support\Facades\Route;

// Route::get('/dashboard', function () {
//     return view('vendor.pages.dashboard');
// })->name('vendor.dashboard');

// Route::get('/inventory', function () {
//     return view('vendor.pages.inventory.create');
// })->name('vendor.inventory');

// Route::get('/orders', function () {
//     return view('vendor.pages.orders.create');
// })->name('vendor.orders');

// Route::get('/advertising', function () {
//     return view('vendor.pages.advertising.advertising1');
// })->name('vendor.advertising');
// Route::get('/advertising2', function () {
//     return view('vendor.pages.advertising.advertising2');
// })->name('vendor.advertising2');
// Route::get('/advertising3', function () {
//     return view('vendor.pages.advertising.advertising3');
// })->name('vendor.advertising3');

// Route::get('/settings', function () {
//     return view('vendor.pages.settings.create');
// })->name('vendor.settings');

// Route::namespace('Vendor')->as('vendor.')->middleware(['auth'])->group(function () {
// });

Route::namespace('Vendor')->as('vendor.')->middleware([])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::match(['get', 'post'], '/dashboard', 'index')->name('dashboard');
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

// Route::namespace('Vendor')->as('vendor.other.')->group(function () {
//     Route::controller(ProductController::class)->prefix('product')->as('product.')->group(function () {
//         Route::get('/list', 'index')->name('list');
//         Route::match(['get', 'post'], '/add', 'createProduct')->name('add');
//         Route::match(['get', 'post'], '/edit/{id}', 'editProduct')->name('edit');
//         Route::get('/delete/{uuid}', 'deleteProduct')->name('delete');
//     });

//     Route::controller(StockController::class)->prefix('stock')->as('stock.')->group(function () {
//         Route::get('/list', 'index')->name('list');
//         Route::match(['get', 'post'], '/add', 'createStock')->name('add');
//         Route::match(['get', 'post'], '/edit/{id}', 'editStock')->name('edit');
//         Route::get('/delete/{uuid}', 'deleteStock')->name('delete');
//     });
// });

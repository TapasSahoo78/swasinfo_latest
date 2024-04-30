<?php

use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/register', function () {
    return view('vendor.pages.dashboard');
})->name('vendor.registraion');

Route::get('/catalogue', function () {
    return view('vendor.pages.catalogue.create');
})->name('vendor.catalogue');

Route::get('/inventory', function () {
    return view('vendor.pages.inventory.create');
})->name('vendor.inventory');

Route::get('/orders', function () {
    return view('vendor.pages.orders.create');
})->name('vendor.orders');

Route::get('/advertising', function () {
    return view('vendor.pages.advertising.advertising1');
})->name('vendor.advertising');
Route::get('/advertising2', function () {
    return view('vendor.pages.advertising.advertising2');
})->name('vendor.advertising2');
Route::get('/advertising3', function () {
    return view('vendor.pages.advertising.advertising3');
})->name('vendor.advertising3');

Route::get('/settings', function () {
    return view('vendor.pages.settings.create');
})->name('vendor.settings');

// Route::namespace('Vendor')->as('vendor.')->middleware(['auth'])->group(function () {
// });

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

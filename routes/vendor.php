<?php

use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/register', function () {
    return view('vendor.pages.registration');
})->name('vendor.registraion');

// Route::namespace('Vendor')->as('vendor.')->middleware(['auth'])->group(function () {
// });

Route::namespace('Vendor')->as('vendor.other.')->group(function () {
    Route::controller(ProductController::class)->prefix('product')->as('product.')->group(function () {
        Route::get('/list', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'createProduct')->name('add');
        Route::match(['get', 'post'], '/edit/{id}', 'editProduct')->name('edit');
        Route::get('/delete/{uuid}', 'deleteProduct')->name('delete');
    });

    Route::controller(StockController::class)->prefix('stock')->as('stock.')->group(function () {
        Route::get('/list', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'createStock')->name('add');
        Route::match(['get', 'post'], '/edit/{id}', 'editStock')->name('edit');
        Route::get('/delete/{uuid}', 'deleteStock')->name('delete');
    });
});

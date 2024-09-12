<?php

use App\Http\Controllers\Frontend\VendorController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;

Route::namespace('Frontend')->as('frontend.')->controller(FrontendController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::match(['get', 'post'], 'product/cart', 'cart')->name('cart');
    Route::match(['get', 'post'], '/shop-by-type/{type?}/{value?}', 'shopByType')->name('shop.by.type');
    Route::get('/shop-by-category/{slug?}', 'shopByCategory')->name('shop.by.category');
    Route::match(['get', 'post', 'put'], '/product/{uuid}', 'productDetails')->name('product.details');
    Route::get('/blogs', 'blogs')->name('blogs');
    Route::get('/blogs-details/{uuid}', 'blogDetails')->name('blogs.details');
    // Route::match(['get','post'],'/contact-us', 'contactUs')->name('contactus');
});

Route::controller(VendorController::class)->group(function () {
    Route::group(['prefix' => 'seller', 'as' => 'seller.'], function () {
        Route::match(['get', 'post'], '/selling-account', 'addVendor')->name('selling.account');
    });
});

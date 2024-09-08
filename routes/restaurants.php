<?php


use Illuminate\Support\Facades\Route;

Route::namespace('Restaurant')->as('restaurant.')->middleware(['auth','restaurantOwner'])->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('home');
        Route::match(['get', 'post'], '/change-password', 'changePassword')->name('change.password');
        Route::match(['get', 'post'], '/profile', 'profile')->name('profile');
        Route::get('/admin-users', 'adminUser')->name('user.list');
        Route::match(['get', 'post'], '/admin-users/edit/{uuid}', 'adminUserEdit')->name('user.edit');
    });

    Route::controller(RestaurantProductController::class)->prefix('Products')->as('product.')->group(function () {
        Route::get('/list', 'list')->name('list');
        Route::match(['get', 'post'], '/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
    });

    Route::controller(RestaurantOrderDetailsController::class)->prefix('Orders')->as('order.')->group(function () {
        Route::get('/list', 'index')->name('list');
        Route::match(['get', 'post'], '/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
    });
});

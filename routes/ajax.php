<?php

use App\Http\Controllers\Ajax\VendorController;
use Illuminate\Support\Facades\Route;


Route::namespace('Admin')->controller(AjaxController::class)->as('ajax.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/getRoles', 'getRoles')->name('get.roles');
    Route::get('/getmfis', 'getmfis')->name('get.mfis');
    Route::post('get-states-by-country',  'getState')->name('get.state');
    Route::post('get-cities-by-state', 'getCity')->name('get.city');
    Route::get('/getPermissions', 'getPermissions')->name('get.permissions');
    Route::get('/getSubCategories', 'getSubCategories')->name('get.sub.categories');
    Route::get('/customer-all-data', 'customerAllData')->name('get.customer.data');
    Route::post('/restaurant-subcategory', 'restaurantSubcategory')->name('restaurant.subcategory');

    Route::post('/category-wise-product', 'categoryWiseProduct')->name('category.wise.product');
    Route::get('/autocomplete', 'autocomplete')->name('autocomplete');

    Route::group(['as'  => 'update.'], function () {
        Route::match(['put', 'post'], '/updateStatus', 'setStatus')->name('status');
        Route::match(['put', 'post'], '/updateSales', 'updateSales')->name('updateSales');
        Route::match(['put', 'post'], '/updateDeal', 'updateDeal')->name('updateDeal');
    });

    Route::group(['as'  => 'update.'], function () {
        Route::match(['put', 'post'], '/updateSessionStatus', 'updateSessionStatus')->name('updateSessionStatus');
    });
    Route::group(['as'  => 'delete.'], function () {
        Route::delete('/deleteData', 'deleteData')->name('data');
    });
    Route::group(['as'  => 'edit.'], function () {
        Route::post('/edit-mfi', 'editMfi')->name('edit-mfi');
    });
    Route::group(['as'  => 'edit.'], function () {
        Route::get('/edit-data', 'editData')->name('edit-data');
    });
    Route::group(['as'  => 'view.'], function () {
        Route::get('/view-data', 'viewData')->name('view-data');
    });
    /* Route::group(['as'  => 'view.'], function() {
        Route::get('/verify-lead', 'verifyleads')->name('verify-lead');
    }); */
});

Route::controller(FrontendAjaxController::class)->as('frontend.ajax.')->group(function () {
    Route::post('/getProducts', 'findProducts')->name('get.products');
    Route::post('/add-to-cart', 'addToCart')->name('add.to.cart');
    Route::post('/update-cart', 'updateCart')->name('update.cart');
    Route::post('/remove-from-cart', 'removeFromCart')->name('remove.from.cart');
    Route::post('/clear-cart', 'clearCart')->name('clear.cart');
    Route::post('/store-pickup', 'storePickup')->name('store.pickup');
});

Route::controller(CustomerAjaxController::class)->prefix('customer')->as('ajax.customer.')->middleware(['auth', 'verified', 'role:customer'])->group(function () {
    Route::post('/findAddress', 'findAddress')->name('find.address');
    Route::post('/addAddress', 'addAddress')->name('add.address');
    Route::post('/defaultAddress', 'defaultAddress')->name('default.address');
    Route::post('/deleteAddress', 'deleteAddress')->name('delete.address');
    Route::post('/add-item-to-wishlist', 'addToWishlist')->name('add.to.wishlist');
    Route::post('/remove-item-from-wishlist', 'removeFromWishlist')->name('remove.from.wishlist');
});

// Route::controller(VendorController::class)->prefix('vendor')->as('ajax.vendor.')->middleware(['auth','verified','role:vendor'])->group(function () {
Route::controller(VendorController::class)->prefix('vendor')->as('ajax.vendor.')->group(function () {
    Route::get('/sub-categories', 'getSubCategories')->name('sub.categories');
});

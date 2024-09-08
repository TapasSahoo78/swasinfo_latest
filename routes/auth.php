<?php

use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes([
    'verify' => true,
    'login' => true
]);

// Route::get('/', function () {
//     return redirect()->route('login');
// })->middleware(['guest:web']);
Route::namespace('Auth')->controller(LoginController::class)->group(function () {
    Route::get('/admin/login', 'showLoginForm')->name('admin.login');
    // Route::match(['get','post'],'/','showLoginForm')->name('login');
});
// restaurants
Route::namespace('Auth')->controller(LoginController::class)->group(function () {
    Route::get('/restaurants/login', 'showRestaurantsLoginForm')->name('restaurants.login');
    Route::post('/restaurants/login', 'restaurantsLogin')->name('restaurants.login');
});
Route::namespace('Auth')->controller(RegisterController::class)->group(function () {
    Route::match(['get', 'post'], '/signup', 'registration')->name('signup');
});
Route::namespace('Auth')->controller(VerificationController::class)->group(function () {
    Route::get('/email-verification-success', 'userEmailVerificationSuccess')->name('user.email.verification.success');
});

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm']);

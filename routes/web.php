<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.pages.homepage');
})->name('frontend.home');

Route::get('/contact-us', function () {
    return view('frontend.pages.contact_us');
})->name('frontend.contact');

Route::get('/ecom', function () {
    return view('ecom.layouts.main');
})->name('frontend.ecom');

Route::get('/branch', function () {
    // return redirect('admin/login');
    return view('admin.branch.list');
});


// Route::get('/selling-account', function () {
//     return view('frontend.pages.selling_account');
// })->name('selling.account');


Route::get('/home/{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/planexpires', [App\Http\Controllers\HomeController::class, 'userPlanExpires'])->name('planexpires');
Route::get('/send-notification', [App\Http\Controllers\HomeController::class, 'sendNotification'])->name('send-notification');
Route::get('/send-notificationtwo', [App\Http\Controllers\HomeController::class, 'sendNotificationTwo'])->name('send-notificationtwo');

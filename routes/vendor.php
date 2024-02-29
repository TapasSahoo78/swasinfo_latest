<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('vendor.pages.registration');
})->name('vendor.registraion');

Route::namespace('Vendor')->as('vendor.')->middleware(['auth'])->group(function () {
});

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('vendor.pages.dashboard');
});

Route::namespace('Vendor')->as('vendor.')->middleware(['auth'])->group(function () {
});

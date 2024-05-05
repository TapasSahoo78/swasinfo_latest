<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdvertisingController extends Controller
{
    public function createAdOne()
    {
        return view('vendor.pages.advertising.advertising1');
    }
    public function createAdTwo()
    {
        return view('vendor.pages.advertising.advertising2');
    }
    public function createAdThree()
    {
        return view('vendor.pages.advertising.advertising3');
    }
}

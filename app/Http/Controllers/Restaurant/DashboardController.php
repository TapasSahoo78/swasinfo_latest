<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Services\RestaurantService\RestaurantService;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('restaurant.dashboard.dashboard');
    }
}

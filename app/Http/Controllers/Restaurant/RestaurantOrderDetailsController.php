<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\BaseController;
use App\Models\RestaurantOrderDetails;
use Illuminate\Http\Request;

class RestaurantOrderDetailsController extends BaseController
{
    public function index()
    {
        return view('restaurant.order-details.list');
    }
}

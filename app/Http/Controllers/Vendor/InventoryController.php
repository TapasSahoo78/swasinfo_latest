<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function createInventory()
    {
        return view('vendor.pages.inventory.create');
    }
}

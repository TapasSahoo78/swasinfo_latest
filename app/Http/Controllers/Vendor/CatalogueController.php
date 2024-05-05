<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function createCatalogue()
    {
        return view('vendor.pages.catalogue.create');
    }
}

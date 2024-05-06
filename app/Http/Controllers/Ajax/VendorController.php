<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function getSubCategories(Request $request)
    {
        $sub_category = Subcategory::where('category_id', $request->categoryId)->get();
        return response()->json($sub_category);
    }
}

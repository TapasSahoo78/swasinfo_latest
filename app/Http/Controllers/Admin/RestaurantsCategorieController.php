<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\RestaurantsCategorie;
use App\Models\RestaurantsSubCategorie;
use Illuminate\Http\Request;

class RestaurantsCategorieController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setPageTitle('All Products');
        if (auth()->user()->id == 1) {
            $listCategories = RestaurantsCategorie::orderBy('created_at', 'desc')->get();
        } else {
            $listCategories = RestaurantsCategorie::orderBy('created_at', 'desc')->get();
        }
        return view('admin.restaurants-category.list', compact('listCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->setPageTitle('Add Restaurant');
        if ($request->post()) {
            $isCreate = RestaurantsCategorie::create([
                'name' => $request->category_name,
                // 'parent_id' => $request->parent_id ?? null,
                'created_by' => auth()->user()->id,
            ]);
            // if ($isCreate) {
            return $this->responseRedirect('admin.restaurant.category.list', 'Restaurant created successfully', 'success');
            // } else {
            //     return $this->responseRedirect('admin.restaurant.category.list', 'Restaurant created successfully', 'success' );
            // }
        }
        // $listCategories = RestaurantsCategorie::orderBy('created_at', 'desc')->get();

        return view('admin.restaurants-category.add-category');
    }

    // **********************************************************************************
    // subCategoryList
    public function subCategoryList()
    {
        $this->setPageTitle('Sub Category List');
        $listSubCategories = RestaurantsSubCategorie::orderBy('created_at', 'desc')->get();
        return view('admin.restaurants-sub-category.list', compact('listSubCategories'));
    }
    // createSubCategory
    public function createSubCategory(Request $request)
    {
        $this->setPageTitle('Add Sub Category');
        if ($request->post()) {
            $isCreate = RestaurantsSubCategorie::create([
                'name' => $request->category_name,
                'category_id' => $request->category_id,
                'created_by' => auth()->user()->id,
            ]);
            return $this->responseRedirect('admin.restaurant.category.subcategory.list', 'Sub Category created successfully', 'success');
        }
        $listCategories = RestaurantsCategorie::orderBy('created_at', 'desc')->get();
        return view('admin.restaurants-sub-category.add-sub-category',compact('listCategories'));
    }
}

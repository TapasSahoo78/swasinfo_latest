<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\BaseController;
use App\Models\Restaurant\RestaurantProduct;
use App\Models\RestaurantsCategorie;
use App\Models\RestaurantsSubCategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RestaurantProductController extends BaseController
{
    
    public function list()
    {
        $data = RestaurantProduct::all();
        return view('restaurant.category-product.index', compact('data'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|integer|exists:restaurants_categories,id',
                'price' => 'required|numeric',
                'discount_price' => 'nullable|string|max:255',
                'description' => 'nullable|string',
            ]);
            DB::beginTransaction();
            try {
                $product = new RestaurantProduct();
                $product->name = $request->name;
                $product->category_id = $request->category_id;
                $product->sub_category_id = $request->sub_category_id;
                $product->price = $request->price;
                $product->discount_price = $request->discount;
                $product->description = $request->description;
                $product->created_by = auth()->user()->id;
                $product->restaurant_id = auth()->user()->restaurant->id;
                $product->save();
                if ($request->hasFile('image')) {
                    $request->validate([
                        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    ]);
                    $image = $request->file('image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images'), $imageName);
                    $restaurantMedia = new \App\Models\RestaurantMedia();
                    $restaurantMedia->uuid = Str::uuid();
                    $restaurantMedia->user_id = auth()->user()->id;
                    $restaurantMedia->restaurant_id = auth()->user()->restaurant->id;
                    $restaurantMedia->mediaable_id = $product->id;
                    $restaurantMedia->mediaable_type = RestaurantProduct::class;
                    $restaurantMedia->media_type = 'image';
                    $restaurantMedia->file = $imageName;
                    $restaurantMedia->save();
                }
                // add media 
                DB::commit();
                return $this->responseRedirect('restaurant.product.list', 'Product created successfully', 'success', false);
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        $data = RestaurantsCategorie::where('is_active', 1)->get();
        $subcategory = RestaurantsSubCategorie::where('is_active', 1)->get();
        return view('restaurant.category-product.add', compact('data', 'subcategory'));
    }
}

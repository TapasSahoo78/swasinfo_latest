<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Restaurant;
use App\Models\Role;
use Illuminate\Http\Request;

class RestaurantController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->setPageTitle('All Restaurants');
        if (auth()->user()->id == 1) {
            $listRestaurant = Restaurant::orderBy('created_at', 'desc')->get();
        } else {
            $listRestaurant = Restaurant::where('created_by', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        }
        return view('admin.restaurant.list', compact('listRestaurant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addRestaurant(Request $request)
    {
        $this->setPageTitle('Add Restaurant');
        if ($request->post()) {
            // $request->validate([
            //     'name' => 'required|string|max:255',
            //     'phone' => 'required|string|max:20',
            //     'lat' => 'required|numeric',
            //     'long' => 'required|numeric',
            //     'is_featured' => 'required|in:dinning,delivery,both,other',
            //     'address' => 'required|string|max:255',
            //     'first_name' => 'required|string|max:255',
            //     'last_name' => 'required|string|max:255',
            //     'email' => 'required|email|unique:users,email',
            //     'mobile_number' => 'required|string|max:20',
            //     'password' => 'required|string|min:8',
            // ]);

            \DB::beginTransaction();
            try {
                $restaurant = new Restaurant();
                $restaurant->name = $request->name;
                $restaurant->phone = $request->phone;
                $restaurant->lat = $request->lat;
                $restaurant->long = $request->long;
                $restaurant->is_featured = $request->is_featured;
                $restaurant->address = $request->address;
                $restaurant->user_id = auth()->user()->id;
                $restaurant->save();
                // dd($request->all());

                $user = new \App\Models\User();
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->mobile_number = $request->mobile_number;
                $user->password = bcrypt($request->password);
                $user->save();

                $restaurant->user_id = $user->id;
                $restaurant->save();

                if ($user) {
                    $isRole = Role::where('slug', 'restaurant_owner')->first();
                    $user->roles()->attach($isRole);
                }
                \DB::commit();
                return $this->responseRedirect('admin.restaurant.list', 'Restaurant created successfully', 'success', false);
            } catch (\Exception $e) {
                \DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.restaurant.add-restaurant');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        //
    }
}

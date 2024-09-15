<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Customer\GymBookingListCollection;
use App\Http\Resources\Api\Customer\GymDetailsCollection;
use App\Http\Resources\Api\Customer\GymListCollection;
use App\Models\GymBooking;
use App\Models\GymCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GymTrainerController extends BaseController
{
    public function gymsList()
    {
        $gymList = User::whereHas('roles', function ($query) {
            $query->where('slug', 'gym-trainer');
        })
            ->with(['gymPersonalDetails', 'gymCenterDetails']) // Eager load relationships
            ->has('gymPersonalDetails')
            ->has('gymCenterDetails')
            ->paginate(30);

        return $this->responseJson(true, 200, "", GymListCollection::collection($gymList));
    }

    public function gymsDetails(Request $request)
    {
        $gymDetails = User::with(['gymPersonalDetails', 'gymBusinessDetails', 'gymCenterDetails']) // Eager load relationships
            ->has('gymPersonalDetails')
            ->has('gymBusinessDetails')
            ->has('gymCenterDetails')
            ->where('id', $request->gym_id)
            ->first();
        return $this->responseJson(true, 200, "", new GymDetailsCollection($gymDetails));
    }

    public function slotBookingGymCustomer(Request $request)
    {
        $userId = Auth::id();

        $validator = Validator::make($request->all(), [
            'gym_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->whereExists(function ($subQuery) {
                        $subQuery->select(DB::raw(1))
                            ->from('users_roles')
                            ->join('roles', 'users_roles.role_id', '=', 'roles.id')
                            ->where('roles.slug', 'gym-trainer')
                            ->whereColumn('users_roles.user_id', 'users.id');
                    });
                })
            ],
            'gym_category' => 'required|exists:gym_categories,name',
            'start_date' => 'required',
            'timing' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }

        DB::beginTransaction();
        try {
            $gymFindId = User::whereHas('roles', function ($query) {
                $query->where('slug', 'gym-trainer');
            })->with('gymCenterDetails')
                ->has('gymCenterDetails')
                ->find($request->gym_id);
            $gymCategoryId = GymCategory::where('name', $request->gym_category)->first();
            $gymData = new GymBooking();
            $gymData->user_id = $userId;
            $gymData->gym_management_id = $gymFindId?->gymCenterDetails?->id;
            $gymData->gym_category_id = $gymCategoryId?->id;
            $gymData->start_date = $request->start_date;
            $gymData->timing = $request->timing;
            $gymData->create_by = $userId;
            $gymData->save();

            if ($gymData) {
                DB::commit();
                return $this->responseJson(true, 200, "Success", $gymData);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            info($th);
            return response()->json(['status' => false, 'message' => $th->getMessage() . '/' . $th->getLine() . '/' . $th->getFile(), 'data' => (object)[]], 500);
        }
    }

    public function workoutBookingCustomer(Request $request)
    {
        $userId = Auth::id();

        $validator = Validator::make($request->all(), []);
        if ($validator->fails()) {
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        try {
            $bookingData = GymBooking::with('userDetails', 'gymCategory', 'gymManage')->where('user_id', $userId)->get();
            if ($bookingData) {
                DB::commit();
                return $this->responseJson(true, 200, "Success", GymBookingListCollection::collection($bookingData));
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            info($th);
            return response()->json(['status' => false, 'message' => $th->getMessage() . '/' . $th->getLine() . '/' . $th->getFile(), 'data' => (object)[]], 500);
        }
    }

    public function workoutBookingCancel(Request $request)
    {
        // $userId = Auth::id();

        $validator = Validator::make($request->all(), [
            'gym_id' => 'required|exists:gym_bookings,id',
            'status' => 'required|in:1,2'
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        try {
            $bookingData = GymBooking::where('id', $request->gym_id)->first();
            if ($bookingData) {
                $bookingData->status = $request->status;
                $bookingData->save();
                DB::commit();
                return $this->responseJson(true, 200, "Success", new GymBookingListCollection($bookingData));
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            info($th);
            return response()->json(['status' => false, 'message' => $th->getMessage() . '/' . $th->getLine() . '/' . $th->getFile(), 'data' => (object)[]], 500);
        }
    }
}

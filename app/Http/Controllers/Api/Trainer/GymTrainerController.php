<?php

namespace App\Http\Controllers\Api\Trainer;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GymCategory;
use App\Models\GymDay;
use App\Models\GymFacilities;
use App\Models\GymManagement;
use App\Models\GymTrainerBusinessDetail;
use App\Models\GymTrainerPersonalDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Days;

class GymTrainerController extends BaseController
{

    public function GymCommonData()
    {
        $userId = Auth::id();
        try {
            $data['categories'] = GymCategory::select('name', 'slug')->get();
            $data['days'] = GymDay::select('name', 'slug')->get();
            $data['facilities'] = GymFacilities::select('name', 'slug')->get();
            if ($data) {
                return $this->responseJson(true, 200, "Common Data", $data);
            }
        } catch (\Throwable $th) {
            info($th);
            return response()->json(['status' => false, 'message' => $th->getMessage() . '/' . $th->getLine() . '/' . $th->getFile(), 'data' => (object)[]], 500);
        }
    }

    public function GymCreateProfile(Request $request)
    {
        $userId = Auth::id();

        $validator = Validator::make($request->all(), [
            'gym_name' => 'required|string',
            'owner_name' => 'required|string',
            'alter_mobile_number' => 'required|string',
            'gym_logo' => 'required',
            'bank_name' => 'required|string',
            'account_holder_name' => 'required|string',
            'account_number' => 'required|numeric|min:9999999',
            'ifsc_code' => 'required|string',
            'cancel_cheque' => 'required',
            'pan_holder_name' => 'required|string',
            'pan_number' => 'required|string',
            'gst_number' => 'required|string',
            'msme_number' => 'required|string',
            'shop_certificate_number' => 'required|string',
            'gym_category_ids' => 'required|array',
            'days' => 'required|array',
            'closing_day' => 'required|string',
            'about_us' => 'required|string',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'facilities' => 'required|array',
        ]);
        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return $this->responseJson(false, 200, $validator->errors()->first(), "");
        }
        $gym_category_ids = is_array($request->gym_category_ids) ? $request->gym_category_ids : explode(",", $request->gym_category_ids);
        $days = is_array($request->days) ? $request->days : explode(",", $request->days);
        $facilities = is_array($request->facilities) ? $request->facilities : explode(",", $request->facilities);
        // $request->merge(['gym_category_ids' => $gym_category_ids, 'days' => $days, 'facilities' => $facilities]);

        DB::beginTransaction();
        try {
            $userData = User::where('id', $userId)->first();
            if ($userData) {

                $userData->first_name = $request->owner_name;
                $userData->is_profile_completed = 1;
                $userData->save();

                $userPersonalData = GymTrainerPersonalDetail::where('user_id', $userId)->first();
                if (empty($userPersonalData)) {
                    $userPersonalData = new GymTrainerPersonalDetail();
                    $userPersonalData->user_id = $userId;
                }

                $userPersonalData->gym_name = $request->gym_name;
                $userPersonalData->alter_mobile_number = $request->alter_mobile_number;

                if ($request->hasFile('gym_logo')) {
                    $file = $request->file('gym_logo');
                    $fileName = rand() . time() . '.' . $file->getClientOriginalExtension();
                    // Check if there is an existing image associated with the model
                    if (File::exists(public_path('uploads/' . $userPersonalData?->gym_logo))) {
                        File::delete(public_path('uploads/' . $userPersonalData?->gym_logo));
                    }
                    $file->move(public_path('uploads'), $fileName);
                    $userPersonalData->gym_logo = $fileName;
                }
                if ($request->hasFile('profile_img')) {
                    $file111 = $request->file('profile_img');
                    $fileName111 = rand() . time() . '.' . $file111->getClientOriginalExtension();
                    // Check if there is an existing image associated with the model
                    if (File::exists(public_path('uploads/' . $userPersonalData?->profile_img))) {
                        File::delete(public_path('uploads/' . $userPersonalData?->profile_img));
                    }
                    $file111->move(public_path('uploads'), $fileName111);
                    $userPersonalData->profile_img = $fileName111;
                }
                if ($request->hasFile('cancel_cheque')) {
                    $file22 = $request->file('cancel_cheque');
                    $fileName22 = rand() . time() . '.' . $file22->getClientOriginalExtension();
                    // Check if there is an existing image associated with the model
                    if (File::exists(public_path('uploads/' . $userPersonalData?->cancel_cheque))) {
                        File::delete(public_path('uploads/' . $userPersonalData?->cancel_cheque));
                    }
                    $file22->move(public_path('uploads'), $fileName22);
                    $userPersonalData->cancel_cheque = $fileName22;
                }

                $userPersonalData->bank_name = $request->bank_name;
                $userPersonalData->account_holder_name = $request->account_holder_name;
                $userPersonalData->account_number = $request->account_number;
                $userPersonalData->ifsc_code = $request->ifsc_code;
                $userPersonalData->pan_holder_name = $request->pan_holder_name;
                $userPersonalData->pan_number = $request->pan_number;
                $userPersonalData->save();

                $userBusinessData = GymTrainerBusinessDetail::where('user_id', $userId)->first();
                if (empty($userBusinessData)) {
                    $userBusinessData = new GymTrainerBusinessDetail();
                    $userBusinessData->user_id = $userId;
                }

                $userBusinessData->have_gst = $request->have_gst ? 1 : 0;
                $userBusinessData->have_msme = $request->have_msme ? 1 : 0;
                $userBusinessData->have_shop_certificate = $request->have_shop_certificate ? 1 : 0;

                $userBusinessData->gst_number = $request->gst_number;
                $userBusinessData->msme_number = $request->msme_number;
                $userBusinessData->shop_certificate_number = $request->shop_certificate_number;
                if ($request->hasFile('gst_image')) {
                    $file4 = $request->file('gst_image');
                    $fileName4 = rand() . time() . '.' . $file4->getClientOriginalExtension();
                    // Check if there is an existing image associated with the model
                    if (File::exists(public_path('uploads/' . $userPersonalData?->gst_image))) {
                        File::delete(public_path('uploads/' . $userPersonalData?->gst_image));
                    }
                    $file4->move(public_path('uploads'), $fileName4);
                    $userBusinessData->gst_image = $fileName4;
                }
                if ($request->hasFile('msme_image')) {
                    $file5 = $request->file('msme_image');
                    $fileName5 = rand() . time() . '.' . $file5->getClientOriginalExtension();
                    // Check if there is an existing image associated with the model
                    if (File::exists(public_path('uploads/' . $userPersonalData?->msme_image))) {
                        File::delete(public_path('uploads/' . $userPersonalData?->msme_image));
                    }
                    $file5->move(public_path('uploads'), $fileName5);
                    $userPersonalData->msme_image = $fileName5;
                }
                if ($request->hasFile('shop_certificate_image')) {
                    $file6 = $request->file('shop_certificate_image');
                    $fileName6 = rand() . time() . '.' . $file6->getClientOriginalExtension();
                    // Check if there is an existing image associated with the model
                    if (File::exists(public_path('uploads/' . $userPersonalData?->shop_certificate_image))) {
                        File::delete(public_path('uploads/' . $userPersonalData?->shop_certificate_image));
                    }
                    $file6->move(public_path('uploads'), $fileName6);
                    $userPersonalData->shop_certificate_image = $fileName6;
                }
                $userBusinessData->save();

                $userGymData = GymManagement::where('user_id', $userId)->first();
                if (empty($userGymData)) {
                    $userGymData = new GymManagement();
                    $userGymData->user_id = $userId;
                }
                $userGymData->gym_category_ids = json_encode($gym_category_ids);
                $userGymData->days = json_encode($days);
                $userGymData->closing_day = $request->closing_day;
                $userGymData->about_us = $request->about_us;
                $userGymData->start_time = $request->start_time;
                $userGymData->end_time = $request->end_time;

                $userGymData->facilities = json_encode($facilities);
                $userGymData->save();

                if ($userData) {
                    DB::commit();
                    return $this->responseJson(true, 200, "Profile Data", $userData);
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            info($th);
            return response()->json(['status' => false, 'message' => $th->getMessage() . '/' . $th->getLine() . '/' . $th->getFile(), 'data' => (object)[]], 500);
        }
    }

    public function GymGetProfile(Request $request)
    {
        $userId = Auth::id();
        try {
            $userData = User::where('id', $userId)->with('gymPersonalDetails', 'gymBusinessDetails', 'gymCenterDetails')->first();
            if ($userData) {
                return $this->responseJson(true, 200, "Profile Data", $userData);
            }
        } catch (\Throwable $th) {
            info($th);
            return response()->json(['status' => false, 'message' => $th->getMessage() . '/' . $th->getLine() . '/' . $th->getFile(), 'data' => (object)[]], 500);
        }
    }
}

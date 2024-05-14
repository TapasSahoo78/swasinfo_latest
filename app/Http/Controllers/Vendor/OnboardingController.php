<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OnboardingController extends BaseController
{
    public function addVendor(Request $request)
    {

        $this->setPageTitle('Add Vendor');
        if ($request->post()) {
            $rules = [
                'name' =>  'required|string',
                'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                'mobile_number' => 'required|numeric|unique:users,mobile_number,NULL,id,deleted_at,NULL|regex:/^[0-9]{10}$/',
                'username' => 'required|string'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->responseJson(false, 200, $validator->errors()->first());
            }
            DB::beginTransaction();
            try {
                $isCustomerCreated = User::create([
                    'first_name'         => $request->name,
                    'mobile_number'     => $request->mobile_number,
                    'email'     => $request->email,
                    'username'             => $request->username,
                    'email_verified_at' => \Carbon\Carbon::now(),
                    'password'          => bcrypt('password'),
                    'is_approve'        => 0
                ]);

                if (isset($isCustomerCreated) && !empty($isCustomerCreated)) {
                    $isCustomerRole = Role::where('slug', 'vendor')->first();
                    $isCustomerCreated->roles()->sync($isCustomerRole->id);
                    DB::commit();
                    // return $this->responseRedirect('seller.selling.account', 'Vendor created successfully', 'success', true);
                    return $this->responseJson(true, 200, 'Vendor created successfully', route('vendor.dashboard'));
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseJson(false, 200, 'Something went wrong');
            }
        }
        return view('vendor.pages.registration');
    }
}

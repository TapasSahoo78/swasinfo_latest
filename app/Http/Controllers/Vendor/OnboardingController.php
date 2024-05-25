<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\VendorAccountInformation;
use App\Models\VendorAddress;
use App\Models\VendorTaxInformation;
use App\Models\VendorTellAboutProduct;
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
                'username' => 'required|string',
                'tax_type' => 'required',
                'gst_number' => 'required',
                'cin_number' => 'required',
                'pan_number' => 'required',
                'gst_country' => 'required',
                're_pan_number' => 'required',
                'street_number' => 'required',
                'apartment_number' => 'required',
                'gst_city' => 'required',
                'gst_state' => 'required',
                'gst_postal_code' => 'required',
                'is_signature' => 'required',
                'signature' => 'sometimes',
                'signature_date' => 'required',
                'card_number' => 'required',
                'valid_month' => 'required',
                'valid_yaer' => 'required',
                'card_holder' => 'required',
                'bank_location' => 'required',
                'account_holder' => 'required',
                'ifsc_code' => 'required',
                'bank_account_number' => 'required',
                're_account_number' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->ajaxResponseJson(false, 200, $validator->errors()->first());
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
                    $request->merge(['user_id' => $isCustomerCreated?->id]);
                    VendorAddress::create([
                        'user_id' => $isCustomerCreated?->id,
                        'address_line_one' => $request->address_line_one,
                        'address_line_two' => $request->address_line_two,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country' => $request->country,
                        'postal_code' => $request->postal_code,
                        'why_do_sell' => $request->why_do_sell
                    ]);
                    VendorTaxInformation::create([
                        'user_id' => $isCustomerCreated?->id,
                        'tax_type' => $request->tax_type,
                        'gst_number' => $request->gst_number,
                        'cin_number' => $request->cin_number,
                        'pan_number' => $request->pan_number,
                        'gst_country' => $request->gst_country,
                        're_pan_number' => $request->re_pan_number,
                        'street_number' => $request->street_number,
                        'apartment_number' => $request->apartment_number,
                        'gst_city' => $request->gst_city,
                        'gst_state' => $request->gst_state,
                        'gst_postal_code' => $request->gst_postal_code,
                        'is_signature' => $request->is_signature,
                        'signature' => $request->signature,
                        'signature_date' => $request->signature_date,
                    ]);
                    VendorTellAboutProduct::create([
                        'user_id' => $isCustomerCreated?->id,
                        'is_upc' => $request->is_upc,
                        'is_brand' => $request->is_brand,
                        'is_target_business' => $request->is_target_business,
                        'how_many_products' => $request->how_many_products
                    ]);
                    VendorAccountInformation::create([
                        'user_id' => $isCustomerCreated?->id,
                        'card_number' => $request->card_number,
                        'valid_month' => $request->valid_month,
                        'valid_yaer' => $request->valid_yaer,
                        'card_holder' => $request->card_holder,
                        'bank_location' => $request->bank_location,
                        'account_holder' => $request->account_holder,
                        'ifsc_code' => $request->ifsc_code,

                        'bank_account_number' => $request->bank_account_number,
                        're_account_number' => $request->re_account_number
                    ]);
                    $isCustomerRole = Role::where('slug', 'vendor')->first();
                    $isCustomerCreated->roles()->sync($isCustomerRole->id);
                    DB::commit();
                    // return $this->responseRedirect('seller.selling.account', 'Vendor created successfully', 'success', true);
                    return $this->ajaxResponseJson(true, 200, 'Vendor created successfully', route('vendor.dashboard'));
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->ajaxResponseJson(false, 200, 'Something went wrong');
            }
        }
        return view('vendor.pages.registration');
    }
}

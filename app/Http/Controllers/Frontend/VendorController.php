<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Http\Requests\User\AddCustomerRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportUsers;
use App\Models\ApiHit;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Response;

use App\Models\Log;

class VendorController extends BaseController
{

    protected $roleService;

    protected $userService;

    public function __construct(
        UserService $userService,
        RoleService $roleService
    ) {
        $this->userService    = $userService;
        $this->roleService    = $roleService;
    }

    public function addVendor(Request $request)
    {

        $this->setPageTitle('Add Vendor');
        if ($request->post()) {
            $request->validate([
                'name'     =>  'required|string',
                'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                'mobile_number' => 'required|numeric|unique:users,mobile_number,NULL,id,deleted_at,NULL|regex:/^[0-9]{10}$/',
                'password' => 'required|string'
            ]);
            DB::beginTransaction();
            try {
                $isFaqCreated = $this->userService->createOrUpdateVendor($request->except('_token'));
                if ($isFaqCreated) {
                    DB::commit();
                    return $this->responseRedirect('seller.selling.account', 'Vendor created successfully', 'success', true);
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
                die();
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('frontend.pages.selling_account');
    }
}

<?php

namespace App\Http\Controllers\Mfi;

use App\Http\Controllers\BaseController;
use App\Models\City;
/* use App\Models\UserRole; */
use App\Models\Country;
use App\Models\State;
use App\Services\Branch\BranchService;
use App\Services\Mfi\MfiService;

use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends BaseController
{
    protected $branchService;
    protected $roleService;
    protected $userService;
    protected $mfiService;

    public function __construct(BranchService $branchService, RoleService $roleService, UserService $userService,MfiService $mfiService)
    {
        $this->branchService = $branchService;
        $this->roleService = $roleService;
        $this->userService = $userService;
        $this->mfiService = $mfiService;


    }
    public function listUsers(Request $request)
    {
        $this->setPageTitle('All Users');
        $countryList = Country::where('id', '=', '101')->get();
        $states = State::where('country_id', '=', '101')->get();
        $cities = City::where('country_id', '=', '101')->get();
         $slug = auth()->user()->mfi->code;
       /*  $condition = ''; */
        $filterConditions = [
            /* 'mfi_id' => auth()->user()->mfi_id, */
            'status' => 1,
        ];
        $filterUserConditions = [
            /* 'mfi_id' => auth()->user()->mfi_id, */
           /*  'status' => 1, */
        ];
        $filterRoles = [
            'status' => 1,
            'mfi_id' => auth()->user()->mfi_id,
        ];
        $listBranch = $this->branchService->listBranch($filterConditions, 'id', 'asc', 15);

        $roles = $this->roleService->roleList($filterRoles);

        if($request->has('first_name')){
            $filterUserConditions['first_name']= $request->first_name ;
        }

        if($request->has('branch')){
            $filterUserConditions['branch']= $request->branch ;
        }

        $listUsers = $this->userService->listUsersAll($filterUserConditions,[],'id', 'asc', 15);
        $isMfi = $this->mfiService->findMfiById(auth()->user()->mfi_id);
        $mfiRoles = collect($isMfi->roles)->where('status','=','1');
        //dd($listUsers);
        return view('mfi.users.list', compact('listBranch', 'roles', 'listUsers', 'countryList', 'states', 'cities','mfiRoles','slug'));
    }

    public function attachUserPermission(Request $request, $slug, $id)
    {
        $this->setPageTitle('Attach Permissions');
        $userData = $this->userService->findById($id);
        //return $userData;
        $permissions = $this->userService->getSpecificPermissions();
        $permissions = $permissions->chunk(ceil($permissions->count() / 8));
        if ($request->post()) {
            $request->validate([
                'permission' => 'required|array',
            ]);

            // DB::begintransaction();
            // try {
                $userData->permissions()->delete();
                $isPermissionAttached = $userData->givePermissionsTo((array) $request->permission);
                if ($isPermissionAttached) {
                    DB::commit();
                    $updateUserData = $userData->update(['status'=>1]);
                    return $this->responseRedirectWithQueryString('mfi.administrator.user.list', ['slug' => $slug], 'Permission attached successfully', 'success');
                }
            // } catch (\Exception$e) {
            //     DB::rollBack();
            //     logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            //     return $this->responseRedirectBack('Something Went Wrong', 'error', true);
            // }
        }


        return view('mfi.dashboard.attach-user-permission', compact('permissions', 'userData'));

    }

    public function store(Request $request)
    {
        //return $request->all();
        if ($request->post()) {
            //dd($request->all());
            /* $request->validate([
            'name' => 'required|string',
            'role_id' => 'required|exists:roles,uuid',
            'branch_id' => 'required|exists:branches,uuid',
            'email' => 'required|string|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,mobile_number',
            'landmark' => 'required|string',
            'country_name' => 'required|string',
            'state_name' => 'required|string',
            'city_name' => 'required|string',
            'zip_code' => 'required|numeric',
            'full_address' => 'required|string',
            ]); */
            $id = $request->id;
            //dd($request->all());
            if (!empty($id)) {
                $request->validate([
                    'name' => 'required|string',
                    'role_id' => 'required|exists:roles,uuid',
                    'branch_id' => 'required|exists:branches,uuid',
                    'email' => 'required|string|unique:users,email,' . $id,
                    'phone' => 'required|numeric|digits:10|unique:users,mobile_number,' . $id,
                    'login_id' => 'required|string|min:6|max:8|unique:users,login_id,' . $id,
                    'landmark' => 'required|string',
                    'country_name' => 'required|string',
                    'state_name' => 'required|string',
                    'city_name' => 'required|string',
                    'zip_code' => 'required|numeric|digits:6',
                    'full_address' => 'required|string',
                ]);
                $message = "User Updated Successfully";
            } else {
                $request->validate([
                    'name' => 'required|string',
                    'role_id' => 'required|exists:roles,uuid',
                    'branch_id' => 'required|exists:branches,uuid',
                    'email' => 'required|string|unique:users,email',
                    'phone' => 'required|numeric|digits:10|unique:users,mobile_number',
                    'login_id' => 'required|string|min:6|max:8|unique:users,login_id',
                    'landmark' => 'required|string',
                    'country_name' => 'required|string',
                    'state_name' => 'required|string',
                    'city_name' => 'required|string',
                    'zip_code' => 'required|numeric|digits:6',
                    'full_address' => 'required|string',
                ]);
                $message = "User Created Successfully";
            }

            DB::begintransaction();
            // try {

                $isUserCreated = $this->userService->createOrUpdateUser($request->except('_token'), $id);
                if ($isUserCreated) {
                    DB::commit();
                    $data = ['status' => true, 'message' => $message, 'data' => ['user' => $isUserCreated]];
                    return response($data);

                    /* return $this->responseRedirectBack('Profile updated successfully', 'success', false); */
                }
            // } catch (\Exception$e) {
            //     DB::rollBack();
            //     logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            //     $data = ['status' => false, 'message' => 'Something went wrong !!', 'data' => []];
            //     return response($data);
            // }

        }
    }
}

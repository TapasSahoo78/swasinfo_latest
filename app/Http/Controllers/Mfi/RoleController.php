<?php

namespace App\Http\Controllers\Mfi;

use App\Http\Controllers\BaseController;
use App\Services\MfiRoles\MfiRolesService;
use App\Services\Mfi\MfiService;
use App\Services\Role\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends BaseController
{
    protected $roleService;
    protected $mfiRoleService;
    protected $mfiService;
    public function __construct(RoleService $roleService, MfiRolesService $mfiRoleService, MfiService $mfiService)
    {
        $this->roleService = $roleService;
        $this->mfiRoleService = $mfiRoleService;
        $this->mfiService = $mfiService;
    }

    public function listRoles(Request $request)
    {
        $this->setPageTitle('All Roles');
        /*  $filterConditions = [
        'mfi_id'=>auth()->user()->id
        ]; */
        $isMfi = $this->mfiService->findMfiById(auth()->user()->mfi_id);
        $mfiRoles = $isMfi->mfiRoles;
        // return $mfiRoles[0]->role;
        $slug = auth()->user()->mfi->code;
        // dd($mfiRoles);
        /* dd($isMfi->roles); */
        /*  $listMfiRoles = $this->mfiRoleService->listMfiRoles($filterConditions);
        $listMfiRoles->push('role'); */
        // $user->push();

        /* dd($listMfiRoles); */

        return view('mfi.role.list', compact('mfiRoles', 'slug'));
    }

    public function listPermissions(Request $request)
    {
        $this->setPageTitle('All Permissions');
        return view('admin.permission.index');
    }
    public function addPermissions(Request $request)
    {
        $this->setPageTitle('Add Permission');
        return view('admin.permission.add');
    }
    /* public function addRoles(Request $request){
    $this->setPageTitle('Add Role');
    return view('admin.role.add');
    } */
    public function saveRoles(Request $request)
    {
        $id = $request->id;
        if (!empty($id)) {
            $request->validate([
                'name' => 'required|string|unique:roles,name,' . $id,
                'description' => 'required|string',
                /* 'min_amount' => 'required|numeric|min:30|regex:/^[0-9]+$/',
            'max_amount' => 'required|numeric|gt:min_amount|regex:/^[0-9]+$/', */
            ]);
            $message = "Role Updated Successfully";
        } else {
            $request->validate([
                'name' => 'required|string|unique:roles,name',
                'description' => 'required|string',
            ]);
            $message = "Role Created Successfully";
        }

        DB::beginTransaction();
        /*  try { */
        $isRoleCreated = $this->roleService->createOrUpdateRole($request->except('_token'), $id);
        /* if ($isRoleCreated) { */
        DB::commit();
        $data = ['status' => true, 'message' => $message, 'data' => ['role' => $isRoleCreated]];
        return response($data);
        /* } */
        /* } catch (\Exception$e) {
    DB::rollBack();
    logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
    $data = ['status' => false, 'message' => 'Something went wrong !!', 'data' => []];
    return response($data);

    } */

    }
    public function savePermissions(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required|array|unique:permissions,name',
        ]);
        DB::beginTransaction();
        try {
            $isPermissionCreated = $this->roleService->addPermission($request->only(['name']));
            if ($isPermissionCreated) {
                DB::commit();
                return $this->responseRedirect('admin.permission.list', "Permission Added Successfully", 'success');
            }
        } catch (\Exception$e) {
            DB::rollBack();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something Went Wrong', 'error', true);
        }

    }

    public function attachPermission(Request $request, $slug, $id)
    {

        $this->setPageTitle('Attach Permissions');
        $roleData = $this->roleService->findRoleById($id);
        // return $roleData;
        $permissions = $this->roleService->getSpecificPermissions();
        $permissions = $permissions->chunk(ceil($permissions->count() / 8));
        if ($request->post()) {
            $request->validate([
                'permission' => 'required|array',
            ]);

            // DB::begintransaction();
            // try {
                $roleData->mfiPermissions()->delete();
                $isPermissionAttached = $roleData->givePermissionsTo((array) $request->permission);
                if ($isPermissionAttached) {
                    DB::commit();
                    $updateRolData = $roleData->update(['status'=>1]);
                    return $this->responseRedirectWithQueryString('mfi.administrator.role.list', ['slug' => $slug], 'Permission attached successfully', 'success');
                }
            // } catch (\Exception$e) {
            //     DB::rollBack();
            //     logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            //     return $this->responseRedirectBack('Something Went Wrong', 'error', true);
            // }
        }


        return view('mfi.dashboard.attach-permission', compact('permissions', 'roleData'));

    }
}

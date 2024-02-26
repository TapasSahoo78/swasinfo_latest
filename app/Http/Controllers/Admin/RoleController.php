<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\Role\RoleService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class RoleController extends BaseController
{
    protected $roleService;
    public function __construct(RoleService $roleService)
    {
        $this->roleService= $roleService;
    }


    public function listRoles(Request $request){
        $this->setPageTitle('All Roles');
        $roleList = Role::all();
        return view('admin.role.index', compact('roleList'));
    }

    public function listPermissions(Request $request){
        $this->setPageTitle('All Permissions');
        return view('admin.permission.index');
    }
    public function addPermissions(Request $request){
        $this->setPageTitle('Add Permission');
        return view('admin.permission.add');
    }
    public function addRoles(Request $request){
        $this->setPageTitle('Add Role');
        return view('admin.role.add');
    }
    public function saveRoles(Request $request){

        dd($request->all());
        $request->validate([
            'name'=> 'required|unique:roles,name',
            'short_code'=> 'required|unique:roles,short_code',
            'role_type' => 'required'
        ]);
        DB::beginTransaction();
        try{
            $isRoleCreated= $this->roleService->addRole($request->only(['name','short_code','role_type']));
            if($isRoleCreated){
                DB::commit();
                return $this->responseRedirect('admin.role.list',"Role Added Successfully",'success');
            }
        }catch(\Exception $e){
            DB::rollBack();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something Went Wrong','error',true);
        }


    }
    public function savePermissions(Request $request){

        // dd($request->all());
        $request->validate([
            'name'=> 'required|unique:permissions,name'
        ]);
        DB::beginTransaction();
        try{
            $isPermissionCreated= $this->roleService->addPermission($request->only(['name']));
            if($isPermissionCreated){
                DB::commit();
                return $this->responseRedirect('admin.permission.list',"Permission Added Successfully",'success');
            }
        }catch(\Exception $e){
            DB::rollBack();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something Went Wrong','error',true);
        }


    }

    public function attachPermission(Request $request,$id){
        $this->setPageTitle('Attach Permissions');
        $roleData= $this->roleService->findRoleById($id);
        $permissions= $this->roleService->getAllPermissions();
        $permissions= $permissions->chunk(ceil($permissions->count()/13));
        if($request->post()){
            DB::begintransaction();
            try{
                $roleData->permissions()->detach();
                $isPermissionAttached= $roleData->givePermissionsTo( (array) $request->permission);
                if($isPermissionAttached){
                    DB::commit();
                    return $this->responseRedirect('admin.role.list','Permission attached successfully','success');
                }
            }catch(\Exception $e){
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something Went Wrong','error',true);
            }
        }

        return view('admin.role.attach-permission',compact('permissions','roleData'));

    }
}

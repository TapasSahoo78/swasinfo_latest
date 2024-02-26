<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Http\Requests\User\AddUserRequest;

class SellerController extends BaseController
{

    protected $roleService;

    protected $userService;

    public function __construct(
        UserService $userService,
        RoleService $roleService
    )
    {
        $this->userService    = $userService;
        $this->roleService    = $roleService;
    }
    public function listSellers(Request $request){
        $this->setPageTitle('All Sellers');
        $users = $this->userService->getSellers()->paginate(15);
        return view('admin.seller.index',compact('users'));
    }


    public function addSellers(Request $request){
        $this->setPageTitle('Add Seller');
        return view('admin.seller.seller-add');
    }


    public function store(AddUserRequest $request){
        DB::beginTransaction();
        //dd($request->all());
        try{
            $role= Role::where('slug','seller')->value('id');
            $request->merge(['role_id'=> $role]);
            $isAdminCreated= $this->userService->createAdmin($request->except('_token'));
            if($isAdminCreated){
                DB::commit();
                return $this->responseRedirect('admin.seller.list', 'Seller created Successfully' ,'success',false, false);
            }
        }catch(\Exception $e){
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong','error',true);
        }

        return $this->responseRedirect('admin.seller.list', 'Invitation link has been sent to the seller' ,'success',false, false);
    }


    public function editSellers(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Seller');
        $id = uuidtoid($uuid, 'users');
        $user= $this->userService->findUser($id);
        //dd($user->document);

        if ($request->post()) {
            $this->validate($request, [
            'first_name'     =>  'required|string',
            'last_name'      =>  'required|string',
            'organization_name' => 'required',
            'designation' => 'required',
            'seller_image' => 'sometimes|file|mimes:jpg,png,jpeg'
        ]);

            // dd($request->all());//
            DB::beginTransaction();
            try {
                $isSellerUpdated = $this->userService->updateSeller($request->except(['_token','email']), $id);
                if ($isSellerUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.seller.list', 'Seller updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.seller.seller-edit', compact('user'));
    }






}

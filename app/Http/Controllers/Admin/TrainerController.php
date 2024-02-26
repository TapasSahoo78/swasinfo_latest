<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Http\Requests\User\AddCustomerRequest;

class TrainerController extends BaseController
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
    public function index(Request $request)
    {
        $this->setPageTitle('All Trainers');
        $filterConditions = [];
        $users = $this->userService->getCustomers('trainer',$filterConditions);
        //dd($users);
        return view('admin.trainer.index', compact('users'));
    }
    public function addTrainers(Request $request)
    {
        $this->setPageTitle('Add Trainer');
        if ($request->post()) {
            //dd($request->all());
            $request->validate([
                'type'     =>  'required',
                'name'     =>  'required|string',
                'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                'mobile_number' => 'required|numeric|unique:users,mobile_number,NULL,id,deleted_at,NULL|regex:/^[0-9]{10}$/',
                'password'       => 'required|string',
                'introduction'   =>  'required',
                'trainer_image' => 'sometimes|file|mimes:jpg,png,jpeg',
            ]);
            DB::beginTransaction();
            try {
                $isFaqCreated = $this->userService->createOrUpdateTrainer($request->except('_token'));
                if ($isFaqCreated) {
                    DB::commit();
                    if($request->type == 0){
                        $name ="Trainer";
                    }else if($request->type == 1){
                        $name ="Dietitian";
                    }
                    $massage= $name . ' created successfully';
                    return $this->responseRedirect('admin.trainer.list', $massage, 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.trainer.trainer-add');
    }


    public function store(AddCustomerRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->merge(['registration_ip' => $request->ip()]);
            $isCustomerCreated = $this->userService->createOrUpdateCustomer($request->except('_token'));
            if ($isCustomerCreated) {
                DB::commit();
                return $this->responseRedirect('admin.customer.list', 'Customer created Successfully', 'success', false, false);
            }
        } catch (\Exception $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
    }


    public function editTrainers(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Trainer');
        $id = uuidtoid($uuid, 'users');
        $user = $this->userService->findUser($id);
        if ($request->post()) {
            $this->validate($request, [
                'name'     =>  'required|string',
                'mobile_number' => [
                    'required',
                    'numeric',
                    'regex:/^[0-9]{10}$/',
                    'unique:users,mobile_number,' . $id . ',id,deleted_at,NULL',
                ],
                'introduction'   =>  'required',
                'trainer_image' => 'sometimes|file|mimes:jpg,png,jpeg',
            ]);
            DB::beginTransaction();
            //try {
                $isCustomerUpdated = $this->userService->createOrUpdateTrainer($request->except(['_token', 'email']), $id);
                if ($isCustomerUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.trainer.list', 'Trainer updated successfully', 'success', false);
                }
            //} catch (\Exception $e) {
                //DB::rollback();
                //logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                //return $this->responseRedirectBack('Something went wrong', 'error', true);
            //}
        }
        return view('admin.trainer.trainer-edit', compact('user'));
    }

    public function viewAddress(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'users');
        $this->setPageTitle('Customer Address');
        $addreses = $this->userService->findById($id)?->addressBook->paginate(15);
        return view('admin.customer.view-address-list', compact('addreses'));
    }

    public function editAddress(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Address');
        $id = uuidtoid($uuid, 'addresses');
        $address = $this->userService->findAddress($id);
        if ($request->post()) {
            DB::beginTransaction();
            try {
                $isAddressUpdated = $this->userService->createOrUpdateAddress($request->except('_token'), $id);
                if ($isAddressUpdated) {
                    DB::commit();
                    return $this->responseRedirectWithQueryString('admin.customer.view.address', $isAddressUpdated->user->uuid, 'Address updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.customer.edit-address', compact('address'));
    }
}

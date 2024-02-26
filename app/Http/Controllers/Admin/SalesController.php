<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Http\Requests\User\AddCustomerRequest;

class SalesController extends BaseController
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
        $this->setPageTitle('All Sales Manager');
        $filterConditions = [];
        $users = $this->userService->getCustomers('sales',$filterConditions);
        //dd($users);
        return view('admin.sales.index', compact('users'));
    }
    public function addSales(Request $request)
    {
        $this->setPageTitle('Add Doctor');
        if ($request->post()) {
            //dd($request->all());
            $request->validate([
                'name'     =>  'required|string',
                'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                'mobile_number' => 'required|numeric|unique:users,mobile_number,NULL,id,deleted_at,NULL|regex:/^[0-9]{10}$/',
                'password'       => 'required|string'
            ]);
            DB::beginTransaction();
            try {
                $isFaqCreated = $this->userService->createOrUpdateSales($request->except('_token'));
                if ($isFaqCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.sales.list', 'Sales Manager created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.sales.trainer-add');
    }


    public function store(AddCustomerRequest $request)
    {
      
        DB::beginTransaction();
        try {
            $request->merge(['registration_ip' => $request->ip()]);
            $isCustomerCreated = $this->userService->createOrUpdateCustomer($request->except('_token'));
            if ($isCustomerCreated) {
                DB::commit();
                return $this->responseRedirect('admin.sales.list', 'Customer created Successfully', 'success', false, false);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
    }


    public function editSales(Request $request, $uuid)
    {
        
        $this->setPageTitle('Edit Sales');
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
            ]);
            DB::beginTransaction();
            //try {
                $isCustomerUpdated = $this->userService->createOrUpdateDoctor($request->except(['_token', 'email']), $id);
                if ($isCustomerUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.sales.list', 'Sales Manager updated successfully', 'success', false);
                }
            //} catch (\Exception $e) {
                //DB::rollback();
                //logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                //return $this->responseRedirectBack('Something went wrong', 'error', true);
            //}
        }
        return view('admin.sales.trainer-edit', compact('user'));
    }

    public function reportAgent(Request $request, $uuid)
    {
        $this->setPageTitle('Report');
        return view('admin.sales.report');
    }

   
}

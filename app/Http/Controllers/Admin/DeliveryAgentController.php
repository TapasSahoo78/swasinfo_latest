<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Http\Requests\User\AddUserRequest;
use App\Http\Requests\User\AddCustomerRequest;

class DeliveryAgentController extends BaseController
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
    public function index(Request $request){
        $this->setPageTitle('All Agents');
        $users = $this->userService->getEmployees('delivery-agent','employee')->paginate(15);
        //dd($users);
        return view('admin.delivery-agent.index',compact('users'));
    }


    public function addAgents(Request $request){
        $this->setPageTitle('Add Agent');
        return view('admin.delivery-agent.add');
    }

    public function store(Request $request){
        if ($request->post()) {
            $this->validate($request, [
                'first_name'        =>  'required|string',
                'last_name'         =>  'required|string',
                'email'             =>  'required|email|unique:users',
                'mobile_number' => 'required|numeric|unique:users|regex:/^[0-9]{10}$/',
                'password'          =>  'required|string',
                'confirm_password'  =>  'required|string|same:password',
                'address'           =>  'sometimes|string|min:3|nullable',
                'zipcode'           =>  'sometimes|numeric|nullable',
                'agent_image'       =>  'sometimes|file|mimes:jpg,png,jpeg',
                ]);
            DB::beginTransaction();
            try{
                $request->merge(['registration_ip'=>$request->ip()]);
                $isAgentCreated= $this->userService->createOrUpdateAgent($request->except('_token'));
                if($isAgentCreated){
                    DB::commit();
                    return $this->responseRedirect('admin.delivery.agent.list', 'Delivery Agent created Successfully' ,'success',false, false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }

    }


    public function editAgents(Request $request, $uuid)
    {
        // return $request->all();
        $this->setPageTitle('Edit Agent');
        $id = uuidtoid($uuid, 'users');
        $user= $this->userService->findUser($id);
        if ($request->post()) {
            $this->validate($request, [
                'first_name'        =>  'required|string',
                'last_name'         =>  'required|string',
                'mobile_number' => 'required|numeric|unique:users|regex:/^[0-9]{10}$/',
                // 'password'          =>  'required|string',
                // 'confirm_password'  =>  'required|string|same:password',
                'address'           =>  'sometimes|string|min:3|nullable',
                'zipcode'           =>  'sometimes|numeric|nullable',
                'agent_image'       =>  'sometimes|file|mimes:jpg,png,jpeg',
                ]);
            DB::beginTransaction();
            try {
                $isAgentUpdated = $this->userService->createOrUpdateAgent($request->except(['_token','email']), $id);
                if ($isAgentUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.delivery.agent.list', 'Agent updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.delivery-agent.edit', compact('user'));
    }
}

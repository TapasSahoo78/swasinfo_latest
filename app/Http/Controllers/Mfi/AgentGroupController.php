<?php

namespace App\Http\Controllers\Mfi;

use App\Http\Controllers\BaseController;
/* use App\Models\UserRole; */
use App\Models\Branch;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Services\Branch\BranchService;
use App\Services\Group\AgentGroupService;
use App\Services\Loan\LoanService;
use App\Services\Mfi\MfiService;
use App\Services\Occupation\OccupationService;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentGroupController extends BaseController
{
    protected $branchService;
    protected $roleService;
    protected $userService;
    protected $mfiService;
    protected $loanService;
    protected $occupationService;
    protected $agentGroupService;

    public function __construct(AgentGroupService $agentGroupService, RoleService $roleService, UserService $userService, MfiService $mfiService, LoanService $loanService, OccupationService $occupationService, BranchService $branchService)
    {
        $this->branchService = $branchService;
        $this->agentGroupService = $agentGroupService;
        $this->roleService = $roleService;
        $this->userService = $userService;
        $this->mfiService = $mfiService;
        $this->loanService = $loanService;
        $this->occupationService = $occupationService;

    }
    public function listAgentGroup(Request $request)
    {
        $this->setPageTitle('All Agent Group');
        $filterConditions = [
            'mfi_id' => auth()->user()->mfi_id,
        ];
        $filterBranchConditions = [
            'mfi_id' => auth()->user()->mfi_id,
        ];
        $countryList = Country::where('id', '=', '101')->get();
        $states = State::where('country_id', '=', '101')->get();
        $cities = City::where('country_id', '=', '101')->get();

        for ($i = 0; $i < 7; $i++) {
            $days[] = jddayofweek($i, 1);
        }
        $branch_id = auth()->user()->branch->branch_id;
        //dd($branch_id);
        $leaders = User::whereHas('branch', function ($q) use ($branch_id) {
            $q->where('branch_id', '=', $branch_id);
        })->get();
        $agents = User::whereHas('branch', function ($q) use ($branch_id) {
            $q->where('branch_id', '=', $branch_id);
        })->whereHas(
            'roles', function ($q) {
                $q->where('slug', 'recovery-agent');
            }
        )->get();
        if($request->has('group')){
            $filterConditions['group']= $request->group ;
        }
        if($request->has('gcode')){
            $filterConditions['gcode']= $request->gcode ;
        }
        //dd($agents);
        $listBranch = $this->branchService->listBranch($filterBranchConditions, 'id', 'asc', 15);

        $listGroups = $this->agentGroupService->listGroup($filterConditions, 'id', 'asc', 15);

        //dd($listUsers);
        return view('mfi.agent_group.list', compact('countryList', 'states', 'cities', 'days', 'leaders', 'agents', 'listGroups', 'listBranch'));
    }

    public function addAgentGroup(Request $request)
    {
        if ($request->post()) {
            $id = $request->id;
            //dd($request->all());
            if (!empty($id)) {
                $request->validate([
                    'branch_id' => 'required|exists:branches,id',
                    'code' => 'required|string|unique:groups,code,' . $id,
                    /* 'frequency' => 'required', */
                    'leader_user_id' => 'required|exists:users,id',
                    'user_id' => 'required|array',
                    /* 'Landmark' => 'required|string', */
                    /* 'days' => 'required|array', */
                    'country_name' => 'required',
                    'state_name' => 'required',
                    'city_name' => 'required',
                    'full_address' => 'required|string',
                    'zip_code' => 'required|numeric|digits:6',
                    /* 'remarks' => 'required|string', */
                ]);
                $message = "Group Updated Successfully";
            } else {
                $request->validate([
                    'branch_id' => 'required|exists:branches,id',
                    'code' => 'required|string|unique:groups,code',
                    /* 'frequency' => 'required', */
                    'leader_user_id' => 'required|exists:users,id',
                    'user_id' => 'required|exists:users,id',
                    /* 'Landmark' => 'required|string', */
                    /* 'days' => 'required|array', */
                    'country_name' => 'required',
                    'state_name' => 'required',
                    'city_name' => 'required',
                    'full_address' => 'required|string',
                    'zip_code' => 'required|numeric|digits:6',
                    /* 'remarks' => 'required|string', */
                ]);
                $message = "Group Created Successfully";
            }

            DB::begintransaction();
            /* try { */

            $isUserCreated = $this->agentGroupService->createOrUpdateGroup($request->except('_token'), $id);
            if ($isUserCreated) {
                DB::commit();
                $data = ['status' => true, 'message' => $message, 'data' => ['user' => $isUserCreated]];
                return response($data);

            }
            /* } catch (\Exception$e) { */
            /* DB::rollBack();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            $data = ['status' => false, 'message' => 'Something went wrong !!', 'data' => []];
            return response($data); */
            /*  } */

        }
    }

}

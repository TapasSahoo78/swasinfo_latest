<?php

namespace App\Http\Controllers\Mfi;

use App\Http\Controllers\BaseController;
/* use App\Models\UserRole; */
use App\Models\User;
use App\Services\Branch\BranchService;
use App\Services\Group\AgentGroupService;
use App\Services\Loan\LoanService;
use App\Services\Mfi\MfiService;
use App\Services\Occupation\OccupationService;
use App\Services\Purpose\PurposeService;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends BaseController
{
    protected $branchService;
    protected $roleService;
    protected $userService;
    protected $mfiService;
    protected $loanService;
    protected $occupationService;
    protected $purposeService;
    protected $agentGroupService;

    public function __construct(BranchService $branchService, RoleService $roleService, UserService $userService, MfiService $mfiService, LoanService $loanService, OccupationService $occupationService, PurposeService $purposeService, AgentGroupService $agentGroupService)
    {
        $this->branchService = $branchService;
        $this->roleService = $roleService;
        $this->userService = $userService;
        $this->mfiService = $mfiService;
        $this->loanService = $loanService;
        $this->occupationService = $occupationService;
        $this->purposeService = $purposeService;
        $this->agentGroupService = $agentGroupService;

    }
    public function listCustomers(Request $request)
    {
        $this->setPageTitle('All Customers');

        $filterOccupationConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'status' => 1,
        ];

        $filterLoanConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'status' => 1,
        ];

        $filterConditionsUsers = [
            'mfi_id' => auth()->user()->mfi_id,
        ];

        $filterBranchConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'status' => 1,
        ];

        $filterPurposeConditions = [
            'mfi_id' => auth()->user()->mfi_id,
        ];

        /*  $listBranch = $this->branchService->listBranch($filterConditions, 'id', 'asc', 15);

        $listLoan = $this->loanService->listLoan($filterLoanConditions, 'id', 'asc', 15); */

        $listBranch = $this->branchService->listBranch($filterBranchConditions, 'id', 'asc', 15);

        $listLoans = $this->loanService->listLoan($filterLoanConditions, 'id', 'asc');

        $listOccupation = $this->occupationService->listOccupation($filterOccupationConditions, 'id', 'asc');

        $listPurpose = $this->purposeService->listPurpose($filterPurposeConditions, 'id', 'asc');

        if($request->has('first_name')){
            $filterConditionsUsers['first_name']= $request->first_name ;
        }
        if($request->has('branch')){
            $filterConditionsUsers['branch']= $request->branch;
        }

        $listCustomers = $this->userService->listCustomers($filterConditionsUsers, 'id', 'asc', 15);
        $branch_ids = [];
        $branch_id = auth()->user()->branch->branch_id;

        if ($branch_id) {
            $branch = $this->branchService->findBranchById($branch_id);
            if ($branch->is_head_branch) {
                $filterConditions = ['mfi_id' => auth()->user()->mfi_id];
                $branch_ids = collect($this->branchService->listBranch($filterConditions))->pluck('id')->toArray();
                // $branch_ids = [];
            } else {
                $branch_ids = [$branch_id];
            }

        }
// dd($branch_ids);
        $customers = User::whereHas('branch', function ($q) use ($branch_ids) {
            $q->whereIn('branch_id', $branch_ids);
        })->whereHas(
            'roles', function ($q) {
                $q->where('slug', 'customer');
            }
        )->get();
        $filterGroupConditions = ['mfi_id' => auth()->user()->mfi_id];

//dd($customers);
        $listGroups = $this->agentGroupService->listGroup($filterGroupConditions);

        $agents = User::whereHas('branch', function ($q) use ($branch_id) {
            $q->where('branch_id', '=', $branch_id);
        })->whereHas(
            'roles', function ($q) {
                $q->where('slug', 'recovery-agent');
            }
        )->get();

        // return $listCustomers;
        return view('mfi.customers.list', compact('listCustomers', 'listLoans', 'listOccupation', 'listBranch', 'listPurpose', 'listGroups', 'agents'));
    }

    public function store(Request $request)
    {
        if ($request->post()) {
            $id = $request->customer_id;
            $customer_personal_id = $request->customer_personal_id;
            // dd($request->all());
            //     if (!empty($id)) {
            $request->validate([
                'name' => 'required|string',
                'branch_id' => 'required|exists:branches,uuid',
                'email' => 'nullable|string|unique:users,email,' . $id,
                'mobile_number' => 'required|numeric|digits:10|unique:users,mobile_number,' . $id,
                'alternative_phone' => 'required|numeric|digits:10|unique:customer_personal_details,alternative_phone,' . $customer_personal_id,
                'landmark' => 'required|string',
                'loan_id' => 'required|exists:loans,id',
                // "location_image" => 'required|file|mimes:jpg,png,gif,jpeg',
                // "aadhaar_image" => 'required|file|mimes:jpg,png,gif,jpeg',
                // "customer_image" => 'required|file|mimes:jpg,png,gif,jpeg',
                "address" => 'required|string',
                "aadhaar_address" => 'required|string',

                'account_holder' => 'required|string',
                'account_no' => 'required|string',
                'ifsc_code' => 'required|string',
            ]);

            $message = "Customer Created Successfully";

            DB::begintransaction();
            /* try { */

            $isUserCreated = $this->userService->createOrUpdateCustomer($request->except('_token'), $id);
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

    public function addCustomers(Request $request)
    {
        $this->setPageTitle('Add Customer');

        return view('mfi.customers.add', /* compact('listUsers') */);
    }

    public function personalDetails(Request $request)
    {
        /* return "test"; */
        $id = $request->customer_id;
        $customer_personal_id = $request->customer_personal_id;
        if ($request->post()) {
            $request->validate([
                'title' => 'required|string',
                'name' => 'required|string',
                'email' => 'nullable|string|unique:users,email,' . $id,
                'branch_id' => 'required|exists:branches,uuid',
                'aadhaar_no' => 'required|string',
                'mobile_number' => 'required|numeric|digits:10|unique:users,mobile_number,' . $id,
                'alternative_phone' => 'required|numeric|digits:10|unique:customer_personal_details,alternative_phone,' . $customer_personal_id,
                'loan_id' => 'required|exists:loans,id',
                'landmark' => 'required',
                // "location_image" => 'required|file|mimes:jpg,png,gif,jpeg',
                // "aadhaar_image" => 'required|file|mimes:jpg,png,gif,jpeg',
                // "customer_image" => 'required|file|mimes:jpg,png,gif,jpeg',
                "address" => 'required|string',
                "aadhaar_address" => 'required|string',
            ]);
            $data = ['status' => true, 'message' => 'Personal Details Submitted Successfully', 'data' => []];
            return response($data);

        }
    }
    public function familyDetails(Request $request)
    {
        if ($request->post()) {
            $request->validate([
                'member_name.*' => 'required|string',
                'age.*' => 'required|numeric|max:99|min:18',
                'relation.*' => 'required|string',
                'occupation_id.*' => 'required|string',
            ]);
            $data = ['status' => true, 'message' => 'Personal Details Submitted Successfully', 'data' => []];
            return response($data);

        }
    }
    public function propertyDetails(Request $request)
    {
        if ($request->post()) {
            $request->validate([
                'property_type.*' => 'required|string',
                'property_condition.*' => 'required|string',
                'year.*' => 'required',
            ]);
            $data = ['status' => true, 'message' => 'Personal Details Submitted Successfully', 'data' => []];
            return response($data);

        }
    }
    public function otherLoansDetails(Request $request)
    {
        if ($request->post()) {
            $request->validate([
                'company.*' => 'required|string',
                'total_loan_amount.*' => 'required|numeric',
                'emi_frequency.*' => 'required|string',
                'total_paid_emi.*' => 'required|numeric',
            ]);
            $data = ['status' => true, 'message' => 'Personal Details Submitted Successfully', 'data' => []];
            return response($data);

        }
    }
    public function bankDetails(Request $request)
    {
        if ($request->post()) {
            $request->validate([
                'account_holder' => 'required|string',
                'account_no' => 'required|string',
                'ifsc_code' => 'required|string',
            ]);
            $data = ['status' => true, 'message' => 'Personal Details Submitted Successfully', 'data' => []];
            return response($data);
        }
    }

    public function kycDetailsUpdate(Request $request)
    {
        //return $request->all();
        if ($request->post()) {
            //dd($request->all());
            $id = $request->customer_kyc_id;
            if (!empty($id)) {
                $request->validate([
                    'customer_user_id' => 'required|string|unique:customer_kyc_verifications,user_id,' . $id,
                    /*  'is_verified' => 'required',
                    'is_loan' => 'required', */
                    'purpose_id' => 'required|nullable',
                    'credit_score' => 'required',
                    'family_income_month' => 'required',
                    'monthly_loan_liability' => 'required',
                    /* "kyc_profile_image" => 'required|file|mimes:jpg,png,gif,jpeg' */
                    // 'mfi_id' => 'required|string',

                ]);
                $message = "Kyc Details Updated Successfully";
            } else {
                $request->validate([
                    'customer_user_id' => 'required|string|unique:customer_kyc_verifications,user_id,',
                    /* 'is_verified' => 'required',
                    'is_loan' => 'required', */
                    'purpose_id' => 'required',
                    'credit_score' => 'required',
                    'family_income_month' => 'required',
                    'monthly_loan_liability' => 'required',
                    /*  "kyc_profile_image" => 'required|file|mimes:jpg,png,gif,jpeg' */
                    // 'mfi_id' => 'required|string',
                ]);
                $message = "Kyc Details Created Successfully";
            }

            // DB::begintransaction();
            // try {
            $isBranchOperationAreaCreated = $this->userService->createOrUpdateKycDetails($request->except('_token'), $id);

            if ($isBranchOperationAreaCreated) {

                // DB::commit();
                $data = ['status' => true, 'message' => $message, 'data' => ['branch' => $isBranchOperationAreaCreated]];
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

    public function listCustomersDemands()
    {
        $this->setPageTitle('All Customer Demands');

        $filterLoanConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'status' => 1,
        ];

        $filterConditionsUsers = [
            'mfi_id' => auth()->user()->mfi_id,
        ];
        $filterDemandConditions = [
            'mfi_id' => auth()->user()->mfi_id,
        ];

        $listLoans = $this->loanService->listLoan($filterLoanConditions, 'id', 'asc', 15);

        $listCustomers = $this->userService->listCustomers($filterConditionsUsers, 'id', 'asc', 15);
        $branch_ids = [];
        $branch_id = auth()->user()->branch->branch_id;

        if ($branch_id) {
            $branch = $this->branchService->findBranchById($branch_id);
            if ($branch->is_head_branch) {
                $filterConditions = ['mfi_id' => auth()->user()->mfi_id];
                $branch_ids = collect($this->branchService->listBranch($filterConditions))->pluck('id')->toArray();
                // $branch_ids = [];
            } else {
                $branch_ids = [$branch_id];
            }

        }
        // dd($branch_ids);
        $customers = User::whereHas('branch', function ($q) use ($branch_ids) {
            $q->whereIn('branch_id', $branch_ids);
        })->whereHas(
            'roles', function ($q) {
                $q->where('slug', 'customer');
            }
        )->get();
        $filterGroupConditions = ['mfi_id' => auth()->user()->mfi_id];

        //dd($customers);
        $listGroups = $this->agentGroupService->listGroup($filterGroupConditions);

        $agents = User::whereHas('branch', function ($q) use ($branch_id) {
            $q->where('branch_id', '=', $branch_id);
        })->whereHas(
            'roles', function ($q) {
                $q->where('slug', 'recovery-agent');
            }
        )->get();

        $listDemand = $this->userService->listDemands($filterDemandConditions);
        //dd($listDemand);
        //dd($agents);
        // return $listCustomers;
        return view('mfi.customers.demand-list', compact('listCustomers', 'listDemand', 'listLoans', 'customers', 'listGroups', 'agents'));
    }

    public function demandStore(Request $request)
    {
        //return $request->all();
        if ($request->post()) {
            //dd($request->all());
            $id = $request->id;
            if (!empty($id)) {
                $request->validate([
                    'user_id' => 'required|exists:users,id',
                    'agent_id' => 'required|exists:users,id',
                    'loan_id' => 'required|exists:loans,id',
                    'group_id' => 'sometimes|nullable|exists:groups,id',
                    'loan_amount' => 'required|numeric|min:100|regex:/^[0-9]+$/',
                    'frequency' => 'required',
                    'emi_start_date' => 'required|date|date_format:Y-m-d|after:today',
                    'tenure' => 'required|numeric|min:12|max:52|regex:/^[0-9]+$/',
                    'remarks' => 'sometimes|nullable',

                ]);
                $message = "Customer Demand Updated Successfully";
            } else {
                $request->validate([
                    'user_id' => 'required|exists:users,id',
                    'agent_id' => 'required|exists:users,id',
                    'loan_id' => 'required|exists:loans,id',
                    'group_id' => 'sometimes|nullable|exists:groups,id',
                    'loan_amount' => 'required|numeric|min:100|regex:/^[0-9]+$/',
                    'frequency' => 'required',
                    'emi_start_date' => 'required|date|date_format:Y-m-d|after:today',
                    'tenure' => 'required|numeric|min:12|max:52|regex:/^[0-9]+$/',
                    'remarks' => 'sometimes|nullable',
                ]);
                $message = "Customer Demand Created Successfully";
            }

            // DB::begintransaction();
            // try {
            $isBranchOperationAreaCreated = $this->userService->createOrUpdateCustomerDemand($request->except('_token'), $id);

            if ($isBranchOperationAreaCreated) {

                // DB::commit();
                $data = ['status' => true, 'message' => $message, 'data' => ['branch' => $isBranchOperationAreaCreated]];
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

    public function updateDemandStatus(Request $request)
    {
        //return $request->all();
        if ($request->post()) {
            //dd($request->all());
            $id = $request->demand_id;

            $request->validate([
                'demand_status' => 'required',
                'disbursement_status' => 'required_if:demand_status,2|numeric',
                'notes' => 'sometimes|nullable',
            ]);
            $message = "Demand Status Updated Successfully";

            DB::begintransaction();
            try {
                $isEnquiryCreated = $this->userService->demandStatusChange($request->except('_token'), $id);

                if ($isEnquiryCreated) {
                    DB::commit();
                    $data = ['status' => true, 'message' => $message, 'data' => ['enquiry' => $isEnquiryCreated]];
                    return response($data);

                    /* return $this->responseRedirectBack('Profile updated successfully', 'success', false); */
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                $data = ['status' => false, 'message' => 'Something went wrong !!', 'data' => []];
                return response($data);

            }

        }
    }

    public function listCustomersDisbursment()
    {
        $this->setPageTitle('All Customer Disbursement');


        $filterDemandConditions = [
            'mfi_id' => auth()->user()->mfi_id
        ];

        $listDemand = $this->userService->listDemands($filterDemandConditions);
        //dd($listDemand);
        //dd($agents);
        // return $listCustomers;
        return view('mfi.customers.disburstment', compact('listDemand'));
    }

   

}

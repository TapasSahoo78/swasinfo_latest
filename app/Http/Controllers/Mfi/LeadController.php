<?php

namespace App\Http\Controllers\Mfi;

use App\Http\Controllers\BaseController;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Services\User\UserService;
use App\Services\Branch\BranchService;
use App\Services\Lead\LeadService;
use App\Services\Loan\LoanService;
use App\Services\Group\AgentGroupService;
use App\Services\Enquiry\EnquiryService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeadController extends BaseController
{
    protected $leadService;
    protected $loanService;
    protected $branchService;
    protected $agentGroupService;
    protected $userService;
    protected $enquiryService;
    public function __construct(LeadService $leadService,EnquiryService $enquiryService,AgentGroupService $agentGroupService,UserService $userService,BranchService $branchService,LoanService $loanService)
    {
        $this->leadService = $leadService;
        $this->enquiryService = $enquiryService;
        $this->userService = $userService;
         $this->agentGroupService = $agentGroupService;
         $this->branchService = $branchService;
         $this->loanService = $loanService;

    }
    public function listLeads(Request $request)
    {
        $this->setPageTitle('All Leads');
        $slug = auth()->user()->mfi->code;
        // return $mfiRoles[0]->role;

        $filterConditions = [
            'mfi_id' => auth()->user()->mfi_id,
        ];
         $filterBranchConditions = [
            /* 'mfi_id' => auth()->user()->mfi_id, */
            'status' => 1,
        ];
        $filterGroupConditions = [
            'mfi_id' => auth()->user()->mfi_id
        ];
        $countryList = Country::where('id', '=', '101')->get();
        $states = State::where('country_id', '=', '101')->get();
        $cities = City::where('country_id', '=', '101')->get();
        $filterConditionsUsers = [
            'mfi_id' => auth()->user()->mfi_id,
        ];
        $branch_id = auth()->user()->branch->branch_id;
        $agents = User::whereHas('branch', function ($q) use ($branch_id) {
            $q->where('branch_id', '=', $branch_id);
        })->whereHas(
            'roles', function ($q) {
                $q->where('slug', 'recovery-agent');
            }
        )->get();
        //dd($countryList);
         if($request->has('lead_name')){
            $filterConditions['lead_name']= $request->lead_name ;
        }
        if($request->has('lead_email')){
            $filterConditions['lead_email']= $request->lead_email ;
        }
        $listBranch = $this->branchService->listBranch($filterBranchConditions, 'id', 'asc', 15);
        $listLeads = $this->leadService->listleads($filterConditions, 'id', 'asc', 15);
        $listGroups = $this->agentGroupService->listGroup($filterGroupConditions);
        //dd($listBranch->toArray());
        return view('mfi.leads.list', compact('listLeads', 'countryList', 'states', 'cities','listGroups','agents','listBranch','slug'));
    }

    public function store(Request $request)
    {
        $citieName = $request->city_name;
        $zipCode = $request->zip_code;
        //return $request->all();
        if ($request->post()) {
            //dd($request->all());
            /* $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:leads,email',
            'phone' => 'required|numeric|digits:10|unique:leads,phone',
            'aadhaar_no' => 'required|string|unique:leads,aadhaar_no',
            'country_name' => 'required',
            'state_name' => 'required',
            'city_name' => 'required',
            'zip_code' => 'required|numeric',
            'address' => 'required|string',
            'landmark' => 'required|string'
            ]); */
            $id = $request->id;
            if(!empty($request->branch_id))
            {
                $request->merge(['branch_id'=>$request->branch_id]);
            }else
            {
                $branchId =  getBranchIdByCitiPincode($citieName,$zipCode);
                $request->merge(['branch_id'=>$branchId]);
            }
            if (!empty($id)) {
                $request->validate([
                    'agent_id' => 'required|exists:users,id',
                    'group_id' => 'required|exists:groups,id',
                     'branch_id' => 'required|exists:branches,id',
                    'name' => 'required|string',
                    'email' => 'sometimes|nullable|unique:leads,email,' . $id,
                    'phone' => 'required|numeric|digits:10|unique:leads,phone,' . $id,
                    'aadhaar_no' => 'sometimes|nullable|unique:leads,aadhaar_no,' . $id,
                    'country_name' => 'sometimes|nullable',
                    'state_name' => 'sometimes|nullable',
                    'city_name' => 'sometimes|nullable',
                    'zip_code' => 'required|numeric|digits:6',
                    'address' => 'sometimes|nullable',
                    'landmark' => 'sometimes|nullable',
                ]);
                $message = "Lead updated successfully";
            } else {
                $request->validate([
                    'agent_id' => 'required|exists:users,id',
                    'group_id' => 'required|exists:groups,id',
                     'branch_id' => 'required|exists:branches,id',
                    'name' => 'required|string',
                    'email' => 'sometimes|nullable|unique:leads,email',
                    'phone' => 'required|numeric|digits:10|unique:leads,phone',
                    'aadhaar_no' => 'sometimes|nullable|unique:leads,aadhaar_no',
                    'country_name' => 'sometimes|nullable',
                    'state_name' => 'sometimes|nullable',
                    'city_name' => 'sometimes|nullable',
                    'zip_code' => 'required|numeric|digits:6',
                    'address' => 'sometimes|nullable',
                    'landmark' => 'sometimes|nullable',
                ]);
                $message = 'Lead created successfully';
            }


            DB::begintransaction();
            /* try { */
                $isLeadCreated = $this->leadService->createOrUpdateLead($request->except('_token'),$id);
                if ($isLeadCreated) {
                    DB::commit();
                    $data = ['status' => true, 'message' => $message, 'data' => ['lead' => $isLeadCreated]];
                    return response($data);
                    /* return $this->responseRedirectBack('Profile updated successfully', 'success', false); */
                }
            /* } catch (\Exception$e) { */
                /* DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                $data = ['status' => false, 'message' => 'Something went wrong !!', 'data' => []];
                return response($data); */

            /* } */

        }
    }

     public function verifyLead(Request $request)
    {
        if ($request->post()) {
            //dd($request->all());
            $id = $request->lead_id;

                $request->validate([
                    'is_verified' => 'required',
                    'verified_note'=>'required|string'
                ]);
                $message = "Verified  Successfully";

            DB::begintransaction();
            /* try { */
                $isLeadCreated = $this->leadService->leadVerify($request->except('_token'), $id);

                if ($isLeadCreated) {
                    DB::commit();
                    $data = ['status' => true, 'message' => $message, 'data' => ['lead' => $isLeadCreated]];
                    return response($data);

                    /* return $this->responseRedirectBack('Profile updated successfully', 'success', false); */
                }
            /* } catch (\Exception$e) { */
               /*  DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                $data = ['status' => false, 'message' => 'Something went wrong !!', 'data' => []];
                return response($data); */

            /* } */



        }
    }

    public function enquiryList(Request $request, $slug, $lead_id)
    {
        $this->setPageTitle('All Enquiry');
        $lead_details = $this->leadService->findLeadById($lead_id);
         $filterConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'lead_id'=>$lead_id
        ];
        $filterLeadConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'status' => 1,
        ];
        $filterLoanConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'status' => 1
        ];
        $listEnquiries = $this->enquiryService->listEnquiry($filterConditions, 'id', 'asc', 15);
        $listLeads = $this->leadService->listLeads($filterLeadConditions, 'id', 'asc', 15);
        $listLoans = $this->loanService->listLoan($filterLoanConditions, 'id', 'asc', 15);


        return view('mfi.leads.enquiry-list', compact('listEnquiries', 'listLeads','listLoans','lead_id','lead_details'));

    }

}

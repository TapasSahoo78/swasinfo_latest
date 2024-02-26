<?php

namespace App\Http\Controllers\Api\Agent\Customer;
use Illuminate\Http\Request;
use App\Services\Mfi\MfiService;
use App\Services\Loan\LoanService;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Services\Branch\BranchService;
use App\Http\Controllers\BaseController;
use App\Services\Purpose\PurposeService;
use Illuminate\Support\Facades\Validator;

use App\Services\Occupation\OccupationService;
use App\Http\Resources\Api\Agent\Customer\CustomerKycCollection;
use  App\Http\Resources\Api\Agent\Customer\CustomerApiCollection;
use App\Http\Resources\Api\Agent\Customer\CustomerBankApiCollection;
use App\Http\Resources\Api\Agent\Customer\CustomerDemanadCollection;
use App\Http\Resources\Api\Agent\Disbursement\DisbursementCollection;
use App\Http\Resources\Api\Agent\Customer\CustomerFamilyApiCollection;
use  App\Http\Resources\Api\Agent\Customer\CustomerPersonalApiCollection;

class CustomerApiController extends BaseController
{
    //
    protected $branchService;
    protected $roleService;
    protected $userService;
    protected $mfiService;
    protected $loanService;
    protected $occupationService;
    protected $purposeService;

    public function __construct(BranchService $branchService, RoleService $roleService, UserService $userService, MfiService $mfiService, LoanService $loanService, OccupationService $occupationService, PurposeService $purposeService)
    {
        $this->branchService = $branchService;
        $this->roleService = $roleService;
        $this->userService = $userService;
        $this->mfiService = $mfiService;
        $this->loanService = $loanService;
        $this->occupationService = $occupationService;
        $this->purposeService = $purposeService;

    }
     /**
     * @OA\Get(
     *      path="/agent/customers/list/",
     *      tags={"AgentCustomers"},
     *      operationId="AgentCustomers",
     *      summary="Agent Customer List",
     *      description="Agent Customer List",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function list(Request $request)
    {
        $filterConditionsUsers = [
            'mfi_id' => auth()->user()->mfi_id,
        ];
        // $if($request->page){

        // }
        $listCustomers = $this->userService->listCustomers($filterConditionsUsers, 'id', 'asc');
        // return json_encode($listCustomers[0]->mediaImage);
        return $this->responseJson(true, 200,"",CustomerApiCollection::collection($listCustomers));
    }
    /**
     * @OA\Get(
     *      path="/agent/customers/view/personal-details/{customer_id}",
     *      tags={"Agent View Customer personal details"},
     *      operationId="AgentViewCustomersPersonal",
     *      description="Agent View Customer all personal details by customer id",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function viewPersonalDetails($customerId)
    {
        $filterConditionsUsers = [
            'mfi_id' => auth()->user()->mfi_id,
        ];
        $customer = $this->userService->findCustomer($customerId);
        if(empty($customer))
        {
            return $this->responseJson(false, 422,"Personal Details Not found",[]);
        }
        $personalDetail = $customer->personalDetail;
        return $this->responseJson(true, 200,[],(new CustomerPersonalApiCollection($personalDetail)));
    }
    /**
     * @OA\Get(
     *      path="/agent/customers/view/family-details/{customer_id}",
     *      tags={"Agent View Customer family details"},
     *      operationId="AgentViewCustomersFamily",
     *      description="Agent View Customer all family details by customer id",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function viewFamilyDetails($customerId)
    {
        $filterConditionsUsers = [
            'mfi_id' => auth()->user()->mfi_id,
        ];
        $customer = $this->userService->findCustomer($customerId );
        $familyDetails = $customer->familyDetails;
        return $this->responseJson(true, 200,"",CustomerFamilyApiCollection::collection($familyDetails));
    }

    /**
     * @OA\Post(
     *      path="/agent/customers/add-edit/personal-details",
     *      tags={"Agent Add edit Customer personal details"},
     *      operationId="Agent Add editCustomersPersonal",
     *      description="Agent Add edit Customer all personal details by customer id",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function addEditFamilyDetails(Request $request)
    {
        $customerId = $request->customer_id;
        $familyDetails = $request->family_details;
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'family_details' => 'required|array',
            'family_details.*.occupation_id' => 'required',
            'family_details.*.member_name' => 'required',
            'family_details.*.age' => 'required',
            'family_details.*.relation' => 'required',
        ]);
        if ($validator->fails()) {
            $error=['error' => $validator->errors()->all()];
            return $this->responseJson(false,422,$validator->errors()->all(),"");
        }
        $customerFamily = $this->userService->createOrUpdateCustomerFamily($request->all());
        return $this->responseJson(true, 200,"",$customerFamily);
    }

    /**
     * @OA\Post(
     *      path="/agent/customers/add-edit/family-details",
     *      tags={"Agent Add edit Customer family details"},
     *      operationId="Agent Add editCustomersFamily",
     *      description="Agent Add edit Customer all family details by customer id",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function addEditPersonalDetails(Request $request)
    {
        $customerId = $request->customer_id;
        $validator = Validator::make($request->all(), [
            'customer_id' => 'sometimes|exists:users,id|nullable',
            'title' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email,'.$customerId,
            'aadhaar_no' => 'required|string',
            'mobile' => 'required|string|unique:users,mobile_number,'.$customerId,
            'loan_id' => 'required|string',
            'alternative_phone' => 'required|string',
            'address'=>'required|string',
            'aadhaar_address'=>'required|string',
            'landmark'=>'required|string',
        ]);
        if ($validator->fails()) {
            $error=['error' => $validator->errors()->all()];
            return $this->responseJson(false,422,$validator->errors()->all(),"");
        }
        $customerFamily = $this->userService->updateOrCreatePersonalDetails($request->all());
        return $this->responseJson(true, 200,"",$customerFamily);
    }


     /**
     * @OA\Post(
     *      path="/agent/customers/add-edit/property-details",
     *      tags={"Agent Add edit Customer personal details"},
     *      operationId="Agent Add editCustomersPersonal",
     *      description="Agent Add edit Customer all personal details by customer id",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function addEditPropertyDetails(Request $request)
    {
        $customerId = $request->customer_id;
        $property_details = $request->property_details;
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'property_details' => 'required|array',
            'property_details.*.property_type' => 'required|string',
            'property_details.*.property_condition' => 'required|string',
            'property_details.*.year' => 'required',
        ]);
        if ($validator->fails()) {
            $error=['error' => $validator->errors()->all()];
            return $this->responseJson(false,422,$validator->errors()->all(),"");
        }
        $propertyDetails = $this->userService->updateOrCreatePropertyDetails($request->all());
        return $this->responseJson(true, 200,"",$propertyDetails);
    }
    public function addEditOtherLoanDetails(Request $request)
    {
        $customerId = $request->customer_id;
        $other_loan_details = $request->other_loan_details;
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'other_loan_details' => 'required|array',
            'other_loan_details.*.company' => 'required|string',
            'other_loan_details.*.total_loan_amount' => 'required',
            'other_loan_details.*.emi_frequency' => 'required|string',
            'other_loan_details.*.total_paid_emi' => 'required',
        ]);
        if ($validator->fails()) {
            $error=['error' => $validator->errors()->all()];
            return $this->responseJson(false,422,$validator->errors()->all(),"");
        }
        $otherLoanDetails = $this->userService->updateOrCreateOthernLoanDetails($request->all());
        return $this->responseJson(true, 200,"",$otherLoanDetails);
    }
    public function addEditBankDetails(Request $request)
    {
        $customerId = $request->customer_id;
        $other_loan_details = $request->other_loan_details;
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:users,id',
            'account_holder' => 'required|string',
            'account_no' => 'required',
            'ifsc_code' => 'required|string',
        ]);
        if ($validator->fails()) {
            $error=['error' => $validator->errors()->all()];
            return $this->responseJson(false,422,$validator->errors()->all(),"");
        }
        $bankDetails = $this->userService->updateOrCreateBankDetails($request->all());
        return $this->responseJson(true, 200,"",new CustomerBankApiCollection($bankDetails));
    }
    public function customerKyc(Request $request)
    {
        $customerId = $request->customer_id;
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:users,id',
            'is_verified_all' => 'required|string',
            'is_loan_recommended' => 'required',
            // 'kyc_profile_image' => 'required',
            // 'kyc_doc' => 'required',
            'purpose_id' => 'required|exists:purposes,id',
            'credit_score' => 'required',
            'family_income_month' => 'required',
            'monthly_loan_liability' => 'required',
        ]);
        if ($validator->fails()) {
            $error=['error' => $validator->errors()->all()];
            return $this->responseJson(false,422,$validator->errors()->all(),"");
        }
        $customer = $this->userService->findCustomer($customerId);
        $kycId = NULL;
        if(!empty($customer->kycDetails))
        {
            $kycId = $customer->kycDetails->id;
        }
        $userKycDetails = $this->userService->updateOrCreateKycDetails($request->all(),$kycId);

        return $this->responseJson(true, 200,"",new CustomerKycCollection($userKycDetails));
    }
    public function viewCustomerKyc(Request $request)
    {
        $customerId = $request->customer_id;
        $request->merge(['customer_id'=>$customerId]);
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            $error=['error' => $validator->errors()->all()];
            return $this->responseJson(false,422,$validator->errors()->all(),"");
        }
        $customer = $this->userService->findCustomer($customerId);
        // return $customer->kycDetails;
        if(!empty($customer->kycDetails))
        {
            return $this->responseJson(true, 200,"",new CustomerKycCollection($customer->kycDetails));
        }else
        {
            $message ="Customer Kyc not found";
            return $this->responseJson(false,200,$message,[]);
        }
    }


    public function createCustomerDemand(Request $request)
    {
        $customerId = $request->customer_id;
        $request->merge(['user_id'=>$customerId,'agent_id'=>auth()->user()->id]);
        $validator = Validator::make($request->all(), [
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
        if ($validator->fails()) {
            $error=['error' => $validator->errors()->all()];
            return $this->responseJson(false,422,$validator->errors()->all(),"");
        }
        $demands = $this->userService->createOrUpdateCustomerDemand($request->all());
        if($demands)
        {
            return $this->responseJson(true, 200,"",new CustomerDemanadCollection($demands));
        }else
        {
            $message ="Customer Demand not found";
            return $this->responseJson(false,200,$message,[]);
        }
    }
    public function viewCustomerDemand(Request $request)
    {
        $customerId = $request->customer_id;
        $request->merge(['customer_id'=>$customerId]);
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            $error=['error' => $validator->errors()->all()];
            return $this->responseJson(false,422,$validator->errors()->all(),"");
        }
        $customer = $this->userService->findCustomer($customerId);
        if(!empty($customer->demands))
        {
            return $this->responseJson(true, 200,"",CustomerDemanadCollection::collection($customer->demands));
        }else
        {
            $message ="Customer Demand not found";
            return $this->responseJson(false,200,$message,[]);
        }
    }
    public function pendingDisbursment(Request $request)
    {
        $filterConditionsUsers = [
            'mfi_id' => auth()->user()->mfi_id,
            'demand_status'=>2,
            'disbursement_status'=>0
        ];
        $listDemands = $this->userService->listDemands($filterConditionsUsers, 'id', 'asc');
        return $this->responseJson(true, 200,"",DisbursementCollection::collection($listDemands));
    }
    public function disbursedList(Request $request)
    {
        $filterConditionsUsers = [
            'mfi_id' => auth()->user()->mfi_id,
            'demand_status'=>2,
            'disbursement_status'=>1
        ];
        $listDemands = $this->userService->listDemands($filterConditionsUsers, 'id', 'asc');
        return $this->responseJson(true, 200,"",DisbursementCollection::collection($listDemands));
    }
}

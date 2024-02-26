<?php

namespace App\Http\Controllers\Api\Agent;

use Illuminate\Http\Request;
use App\Services\Loan\LoanService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Services\Purpose\PurposeService;
use App\Services\Group\AgentGroupService;
use App\Services\Occupation\OccupationService;
use App\Http\Resources\Api\Agent\Loan\LoanCollection;
use App\Http\Resources\Api\Agent\Group\GroupCollection;
use App\Http\Resources\Api\Agent\CustomerSettingCollection;
use App\Http\Resources\Api\Agent\Purpose\PurposeCollection;
use App\Http\Resources\Api\Agent\Occupation\OccupationCollection;

class SettingController extends BaseController
{

    protected $loanService;
    protected $occupationService;
    protected $purposeService;
    protected $agentGroupService;

    public function __construct(LoanService $loanService, OccupationService $occupationService, PurposeService $purposeService,AgentGroupService $agentGroupService)
    {

        $this->loanService = $loanService;
        $this->occupationService = $occupationService;
        $this->purposeService = $purposeService;
        $this->agentGroupService = $agentGroupService;

    }
    public function getGuidanceList()
    {
        $toReturn =[
            'guidances'=>getGuidance(),
          
        ];
        return $this->responseJson(true, 200,"",$toReturn);
    }
    public function getCustomerDropdown()
    {
        $filterConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'status' => 1,
        ];
        $listLoans = $this->loanService->listLoan($filterConditions, 'id', 'asc');

        $listOccupation = $this->occupationService->listOccupation($filterConditions, 'id', 'asc');

        $listPurpose = $this->purposeService->listPurpose($filterConditions, 'id', 'asc');
        $listGroups = $this->agentGroupService->listGroup([]);
        $toReturn =[
            'loans'=>LoanCollection::collection($listLoans),
            'occupations'=>OccupationCollection::collection($listOccupation),
            'purposees'=>PurposeCollection::collection($listPurpose),
            'emi_frequency'=>emiFrequencyOption(),
            'property_type'=>propertyTypeOption(),
            'property_condition'=>propertyConditionOption(),
            'relation_option'=>relationOption(),
            'title_option'=>titleOption(),
            'list_groups'=>GroupCollection::collection($listGroups),
        ];
        return $this->responseJson(true, 200,"",new CustomerSettingCollection($toReturn));

    }
}

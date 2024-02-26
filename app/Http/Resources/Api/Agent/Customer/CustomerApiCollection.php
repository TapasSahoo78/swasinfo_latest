<?php

namespace App\Http\Resources\Api\Agent\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
class CustomerApiCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $lastDemand = $this->demands->first();
        $demandLoan = !empty($lastDemand) ? $lastDemand->loan : "";
        $customerStatus ="kyc_verified";
        if(empty($this->familyDetails))
        {
            $customerStatus ="family_details_pending";
        }else if(empty($this->bankDetails))
        {
            $customerStatus ="bank_details_pending";
        }else if(empty($this->kycDetails))
        {
            $customerStatus ="kyc_approval_pending";
        }
        return [
            'name' => $this->first_name,
            'customer_id' => $this->id,
            'title' => $this->title,
            'user_id'=>$this->id,
            'customer_code'=> getCustomerCode($this->id),
            'email'=>$this->email,
            'mobile_number'=>$this->mobile_number,
            // 'mediaImage'=>$this->mediaImage,
            'customer_picture'=>$this->customer_picture,
            'aadhaar_picture'=>$this->aadhaar_picture,
            'customer_status'=>$customerStatus,
            'customer_status_display'=> stringToHuman($customerStatus),
            // 'image'=>$this->image
            'loan_applied_on'=>!empty($lastDemand) ? $lastDemand->created_at : NULL,
            'loan_applied_on_display'=>!empty($lastDemand) ? date('d-M-Y',strtotime($lastDemand->created_at)) : NULL,
            'loan_pending_amount_display'=>!empty($demandLoan) ? (!empty($demandLoan?->loanEmis) ? $demandLoan->loanEmis[0]->emi_amount : NULL) : NULL,
            'loan_tenure_display'=>!empty($lastDemand) ? $lastDemand->tenure ." (". $lastDemand->frequency.")" : NULL,
            'emi'=>!empty($demandLoan) ? (!empty($demandLoan?->loanEmis) ? $demandLoan->loanEmis[0]->emi_amount : NULL):NULL,
            'last_paid_amount'=>!empty($lastDemand) ? $lastDemand->loan_amount : NULL,
            'last_next_amount'=>!empty($demandLoan?->loanEmis) ? $demandLoan->loanEmis[0]->emi_amount : NULL,
            'personal_details'=>!empty($this->personalDetail) ? new CustomerPersonalApiCollection($this->personalDetail):"",
            'family_details'=>!empty($this->familyDetails) ?  CustomerFamilyApiCollection::collection($this->familyDetails):[],
            'property_details'=> !empty($this->propertyDetails) ? CustomerPropertyApiCollection::collection($this->propertyDetails):[],
            'other_loans_details'=>!empty($this->otherLoansDetails) ?  CustomerOtherLoanApiCollection::collection($this->otherLoansDetails):[],
            'demands'=>!empty($this->demands) ? CustomerDemanadCollection::collection($this->demands):[],

            'bank_details'=>!empty($this->bankDetails) ?  new CustomerBankApiCollection($this->bankDetails):"",
        ];
    }
}

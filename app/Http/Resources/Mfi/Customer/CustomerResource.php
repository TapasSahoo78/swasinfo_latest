<?php

namespace App\Http\Resources\Mfi\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Mfi\Customer\CustomerFamilyResource;
use App\Models\Occupation;
class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $filterOccupationConditions = [
            'mfi_id' => auth()->user()->mfi_id,
            'status' => 1,
        ];

        $listOccupation = Occupation::where($filterOccupationConditions)->get(); ;

        return [
            'customer_id'=>$this->id,
            'mfi_id'=> $this->mfi_id,
            'title'=> $this->title,
            'branch_id'=>$this->branch->branch->uuid,
            'name'=>$this->first_name,
            'email'=>$this->email,
            'mobile_number'=>$this->mobile_number,
            'loan_id'=>$this->personalDetail->loan_id,
            'customer_personal_id'=>$this->personalDetail->id,

            'loan_group'=>$this->personalDetail->loan_group ,
            'aadhaar_no'=>$this->personalDetail->aadhaar_no,
            'alternative_phone'=>$this->personalDetail->alternative_phone,
            'address'=>$this->personalDetail->address,
            'aadhaar_address'=>$this->personalDetail->aadhaar_address,
            'landmark'=>$this->personalDetail->landmark,
            'status'=>1,
            'account_holder'=>$this->bankDetails->account_holder,

            'account_no'=>$this->bankDetails->account_no,

            'ifsc_code'=>$this->bankDetails->ifsc_code,

            'created_by'=>$this->id,
            'updated_by'=>$this->id,
            'customer_other_loan_details_html'=> view('mfi.customers.components.other-loan')->with(['other_loans_details' => $this->otherLoansDetails])->render(),

            'customer_family_details_html'=> view('mfi.customers.components.family-detail')->with(['family_details' => $this->familyDetails,'listOccupation'=>$listOccupation])->render(),

            'customer_property_details_html'=>view('mfi.customers.components.property-detail')->with(['property_details' => $this->propertyDetails])->render(),

        ];

    }
}

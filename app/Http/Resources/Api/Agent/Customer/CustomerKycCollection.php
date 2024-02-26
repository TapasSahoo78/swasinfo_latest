<?php

namespace App\Http\Resources\Api\Agent\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerKycCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $docUrls = getDocumentsUrl([$this->singleDocument]);
        return [
            // 'name' => $this->user->name,
            'customer_id' => $this->user_id,
            'user_id' => $this->user_id,
            'is_verified_all'=>$this->is_verified_all,
            'is_loan_recommended'=>$this->is_loan_recommended,
            'purpose_id'=>$this->purpose_id,
            'credit_score'=>$this->credit_score,
            'family_income_month'=>$this->family_income_month,
            'monthly_loan_liability'=>$this->monthly_loan_liability,
            'mfi_id'=>$this->mfi_id,
            'kyc_picture'=>$this->kyc_picture,
            'kyc_document'=> count($docUrls) ? $docUrls[0] :"",
            'customer_kyc_id'=>$this->id
        ];

    }
}

<?php

namespace App\Http\Resources\Mfi\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerKycResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        //dd($this->branches->first());
        return [
            'customer_user_id' => $this->id,
            'customer_uuid' => $this->uuid,
            'customer_kyc_id' =>!empty( $this->kycDetails) ?  $this->kycDetails->id : "",
            'is_verified_all' => !empty( $this->kycDetails) ?  $this->kycDetails->is_verified_all : "",
            'is_loan_recommended' => !empty( $this->kycDetails) ?  $this->kycDetails->is_loan_recommended : "",
            'purpose_id' =>!empty( $this->kycDetails) ?  $this->kycDetails->purpose_id : "",
            'credit_score' => !empty( $this->kycDetails) ?  $this->kycDetails->credit_score : "",
            'family_income_month' => !empty( $this->kycDetails) ?  $this->kycDetails->family_income_month : "",
            'monthly_loan_liability' => !empty( $this->kycDetails) ?  $this->kycDetails->monthly_loan_liability : "",
            'kyc_image' => !empty( $this->kycDetails) ?  $this->kycDetails->kyc_picture : ""
        ];

    }
}

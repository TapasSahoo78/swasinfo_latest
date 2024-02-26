<?php

namespace App\Http\Resources\Mfi\Demand;

use Illuminate\Http\Resources\Json\JsonResource;

class DemandCustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
        'id' => $this->id,
        'uuid' => $this->uuid,
        'name' => $this->first_name,
        'loan_amount'=>33450,
        'aadhaar_no'=>!empty( $this->personalDetail) ?  $this->personalDetail->aadhaar_no : "",
        "credit_score"=>!empty( $this->kycDetails) ?  $this->kycDetails->credit_score : "",
        ];

    }
}

<?php

namespace App\Http\Resources\Mfi\Lead;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerLeadResource extends JsonResource
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
            'lead_uuid' => $this->uuid,
            'name' => $this->name,
            'mfi_id'=> $this->mfi_id,
            'branch_id'=>$this->branch->uuid,
            'email' => $this->email,
            'mobile_number' => $this->phone,
            'aadhaar_no' => $this->aadhaar_no,
            'loan_id'=>$this->enquiry?->lead_id,
            'country_name' => $this->country_name,
            'state_name' => $this->state_name,
            'city_name' => $this->city_name,
            'zip_code' => $this->zip_code,
            'address' => $this->address,
            'landmark' => $this->landmark,
        ];
    }
}

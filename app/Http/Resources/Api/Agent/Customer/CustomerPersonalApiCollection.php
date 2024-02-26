<?php

namespace App\Http\Resources\Api\Agent\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerPersonalApiCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'person_id' => $this->id,
            'loan_id' => $this->loan_id,
            'loan_name' => $this->loan->name,
            // 'user_id' => $this->user_id,
            'aadhaar_no' => $this->aadhaar_no,
            'alternative_phone' => $this->alternative_phone,
            'address' => $this->address,
            'aadhaar_address' => $this->aadhaar_address,
            'landmark' => $this->landmark,
        ];
    }
}

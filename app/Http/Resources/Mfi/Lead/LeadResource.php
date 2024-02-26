<?php

namespace App\Http\Resources\Mfi\Lead;

use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
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
            'branch_id' => $this->branch_id,
            'group_id' => $this->group_id,
            'agent_id' => $this->agent_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'aadhaar_no' => $this->aadhaar_no,
            'country_name' => $this->country_name,
            'state_name' => $this->state_name,
            'city_name' => $this->city_name,
            'zip_code' => $this->zip_code,
            'address' => $this->address,
            'landmark' => $this->landmark,
            'note' => $this->note,
        ];
    }
}

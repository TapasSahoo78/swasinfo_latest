<?php

namespace App\Http\Resources\Mfi\Demand;

use Illuminate\Http\Resources\Json\JsonResource;

class DemandResource extends JsonResource
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
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user_id' => $this->user_id,
            'agent_id' => $this->agent_id,
            'loan_id' => $this->loan_id,
            'loan_amount' => $this->loan_amount,
            'group_id' => !empty($this->group_id)?$this->group_id:'',
            'frequency' => $this->frequency,
            'emi_start_date' => $this->emi_start_date,
            'tenure' => $this->tenure,
            'remarks' => !empty($this->remarks)?$this->remarks:''
           /*  'city_name' => $this->address?->city_name,
            'zip_code' => $this->address?->zip_code,
            'full_address' => $this->address?->full_address,
            'branch_id' => $this->branches->first()->uuid,
            'role_id' => $this->roles->first()->uuid */
        ];

    }
}

<?php

namespace App\Http\Resources\Api\Agent\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerDemanadCollection extends JsonResource
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
        return [
            'demand_id'=>$this->id,
            'loan_amount'=>$this->loan_amount,
            'frequency'=>$this->frequency,
            'emi_start_date'=>$this->emi_start_date,
            'emi_start_date_display'=> !empty($this->emi_start_date) ? date('d-m-Y',strtotime($this->emi_start_date)) :"",
            'tenure'=>$this->tenure,
            'remarks'=>$this->remarks,
            'demand_status'=>$this->demand_status,
            'agent_id'=>$this->agent_id ,
            'group_id'=>$this->group_id ,
            'group_code'=>$this->group->code,
            'agent_name'=>!empty($this->agent) ? $this->agent->first_name :"",
            'disbursement_status'=>$this->disbursement_status,
            'created_by'=>$this->created_by,
            'created_by_user_name'=>!empty($this->created_by) ? $this->createdUser->first_name :"",



        ];
    }
}

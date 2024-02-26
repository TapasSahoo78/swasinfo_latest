<?php

namespace App\Http\Resources\Api\Agent\Disbursement;

use Illuminate\Http\Resources\Json\JsonResource;

class DisbursementCollection extends JsonResource
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
        $disbursementStatus = "Pending";
        if($this->disbursement_status==1)
        {
            $disbursementStatus = "Disbursed";
        }
        $demandStatus = "Rejected";
        if($this->demand_status==1)
        {
            $demandStatus = "Pending";
        }else if($this->demand_status==2)
        {
            $demandStatus = "Approved";
        }else if($this->demand_status==3)
        {
            $demandStatus = "Withdrawal";
        }else if($this->demand_status==4)
        {
            $demandStatus = "On Hold";
        }
        return [
            'customer_name'=>$this->customer->first_name,
            'mobile_number '=>$this->customer->mobile_number ,
            'address'=>$this->customer->address,
            'loan_amount'=>$this->loan_amount,
            'total_loan_amount'=>$this->loan_amount,
            'pending_loan_amount'=>$this->loan_amount,
            'frequency'=>$this->frequency,
            'emi_start_date'=>$this->emi_start_date,
            'tenure'=>$this->tenure,
            'last_emi_paid_date'=>"--",
            'next_emi_due_date'=>"--",
            'status'=>$demandStatus,
            'approved_at'=>$this->created_at,
            'approved_at_display'=> !empty($this->created_at) ? date('d-M-Y ',strtotime($this->created_at)) :"",
            'disbursement_status'=>$disbursementStatus,

        ];
    }
}

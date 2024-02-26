<?php

namespace App\Http\Resources\Api\Agent\Loan;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanCollection extends JsonResource
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
            'loan_id' => $this->id,
            'name' => $this->name,
            'status'=>$this->status? "active" :"inactive",
            'applicability'=>$this->applicability,
            'principal_amount'=>$this->principal_amount,
            'maturity_amount'=>$this->maturity_amount,
            'tenure'=>$this->tenure,
        ];
    }
}

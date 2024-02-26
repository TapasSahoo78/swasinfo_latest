<?php

namespace App\Http\Resources\Api\Agent\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerOtherLoanApiCollection extends JsonResource
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
            'other_loan_id' => $this->id,
            'company' => $this->company,
            'total_loan_amount' => $this->total_loan_amount,
            'emi_frequency' => $this->emi_frequency,
            'total_paid_emi' => $this->total_paid_emi,
        ];
    }
}

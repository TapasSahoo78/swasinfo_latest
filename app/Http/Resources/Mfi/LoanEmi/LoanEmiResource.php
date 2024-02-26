<?php

namespace App\Http\Resources\Mfi\LoanEmi;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanEmiResource extends JsonResource
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
            'loan_emi_id' => $this->id,
            'number_of_week' => $this->number_of_week,
            'emi_amount' => $this->emi_amount,
            'loan_id' => $this->loan_id,

        ];
    }
}

<?php

namespace App\Http\Resources\Mfi\Loan;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
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
        $branches = [];
        if(!empty($this->loanBranches) && count($this->loanBranches) )
        {
            $branches = $this->loanBranches->pluck('branch_id')->toArray();
        }
        return [
            'id' => $this->id,
            'code' => $this->code,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'branches'=> $branches,
            'principal_amount' => $this->principal_amount,
            'maturity_amount' => $this->maturity_amount,
            'applicability'=>$this->applicability,
            'tenure' => $this->tenure,

        ];
    }
}

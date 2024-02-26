<?php

namespace App\Http\Resources\Mfi\Account;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'branch_id' => $this->branch_id,
            'account_type' => $this->account_type,
            'account_sub_type' => $this->account_sub_type,
            'account_name' => $this->account_name,
            'account_number' => $this->account_number,
            'ifsc_code' => $this->ifsc_code,
            'upi_id' => $this->upi_id,
            'account_holder_name' => $this->account_holder_name,
            'opening_balance' => $this->opening_balance,
            'note' => $this->note,
            'status' => $this->status,
        ];
    }
}

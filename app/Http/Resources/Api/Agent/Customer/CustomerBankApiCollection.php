<?php

namespace App\Http\Resources\Api\Agent\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerBankApiCollection extends JsonResource
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
            'bank_id' => $this->id,
            'account_holder' => $this->account_holder,
            'account_no' => $this->account_no,
            'ifsc_code' => $this->ifsc_code,
            'customer_id' => $this->user->id,
            'customer_code' => getCustomerCode($this->user->id)

        ];
    }
}

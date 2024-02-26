<?php

namespace App\Http\Resources\Api\Agent\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerFamilyApiCollection extends JsonResource
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
            'family_id' => $this->id,
            'member_name' => $this->member_name,
            'age' => $this->age,
            'occupation_id'=>$this->occupation_id,
            'relation' => $this->relation,
        ];
    }
}

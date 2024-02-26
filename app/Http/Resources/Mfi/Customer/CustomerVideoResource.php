<?php

namespace App\Http\Resources\Mfi\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerFamilyResource extends JsonResource
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
            'user_id'=>$this->id,
            'mfi_id'=> auth()->user()->mfi_id,
            'occupation_id'=>$this->occupation_id,
            'member_name'=>$this->member_name,
            'age'=>$this->age,
            'relation'=>$this->relation,
            'status'=>1,
        ];
    }
}

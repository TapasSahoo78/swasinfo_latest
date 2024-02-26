<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SubscriptionApiCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'id' => $this->id,
            'uuid' => $this->uuid,
            'price'=>$this->price,
            'frequently_purchased_title'=>$this->frequently_purchased_title,
            'expiry_date'=>$this->expiry_date,
            'day_validity'=>$this->day_validity,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'package'=>!empty($this->courses)? $this->courses:''
        ];
    }
}

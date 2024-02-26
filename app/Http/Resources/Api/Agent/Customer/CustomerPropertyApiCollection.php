<?php

namespace App\Http\Resources\Api\Agent\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerPropertyApiCollection extends JsonResource
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
            'property_id' => $this->id,
            'property_type' => $this->property_type,
            'property_condition' => $this->property_condition,
            'year' => $this->year,
        ];
    }
}

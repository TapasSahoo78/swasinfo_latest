<?php

namespace App\Http\Resources\Mfi\Branch;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            'uuid' => $this->uuid,
            // 'first_name' => $this->first_name,
            'name' => $this->name,
             'code' => $this->code,
            //  'mobile_number' => $this->mobile_number,
            'landmark' => $this->landmark,
            'city_name' => $this->city_name,
            'state_name' => $this->state_name,
            'full_address' => $this->full_address,
            'country_name' => $this->country_name,
            'zip_code' => $this->zip_code
        ];
    }
}

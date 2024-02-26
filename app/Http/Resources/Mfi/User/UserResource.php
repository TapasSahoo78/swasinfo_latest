<?php

namespace App\Http\Resources\Mfi\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        //dd($this->branches->first());
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->first_name,
            'email' => $this->email,
            'phone' => $this->mobile_number,
            'login_id' => $this->login_id,
            'landmark' => $this->address?->landmark,
            'country_name' => $this->address?->country_name,
            'state_name' => $this->address?->state_name,
            'city_name' => $this->address?->city_name,
            'zip_code' => $this->address?->zip_code,
            'full_address' => $this->address?->full_address,
            'branch_id' => $this->branches->first()->uuid,
            'role_id' => $this->roles->first()->uuid
        ];

    }
}

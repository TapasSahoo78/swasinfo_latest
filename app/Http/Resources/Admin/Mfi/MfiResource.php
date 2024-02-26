<?php

namespace App\Http\Resources\Admin\Mfi;

use Illuminate\Http\Resources\Json\JsonResource;

class MfiResource extends JsonResource
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
            'id' => $this->uuid,
            'code' => $this->code,
            'name' => $this->name,
            'registration_number' => $this->registration_number,
            'login_id' => $this->user->login_id,
            'contact_person_name' => $this->user->first_name,
            'user_id' => $this->user->id,
            'contact_person_email' => $this->user->email,
            'contact_person_phone' =>$this->user->mobile_number,
            'registration_number' => $this->registration_number,
            'landmark' =>!empty($this->user->address) ? $this->user->address->landmark :"",
            'country_name' =>!empty($this->user->address) ?  $this->user->address->country_name :"",
            'state_name' =>!empty($this->user->address) ?  $this->user->address->state_name :"",
            'city_name' =>!empty($this->user->address) ?  $this->user->address->city_name :"",
            'zip_code' =>!empty($this->user->address) ?  $this->user->address->zip_code :"",
            'address' => !empty($this->user->address) ? $this->user->address->address :"",
            'full_address' =>!empty($this->user->address) ?  $this->user->address->full_address :"",
            'logo_picture'=>$this->user->mfi->logo_picture
            // 'logo' => $this->user->address->address,
                    
        ];
    }
}

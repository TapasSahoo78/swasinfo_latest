<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserProfileImageDetailApiCollection extends JsonResource
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
            /* 'name' => $this->first_name,
            'first_name'=>$this->first_name,
            'email'=>$this->email,
            'is_profile_completed'=>$this->is_profile_completed,
            'is_password_changed'=>$this->is_password_changed,
            'mobile_number'=>$this->mobile_number, */
           /*  'access_token'=>$this->access_token, */
            'customer_picture'=>$this->customer_picture
            /* 'profile_details'=> !empty($this->profile) ? new UserProfileApiCollection($this->profile):"", */
        ];
    }
}

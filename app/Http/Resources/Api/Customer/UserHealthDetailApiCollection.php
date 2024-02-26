<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserHealthDetailApiCollection extends JsonResource
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
            'name' => $this->first_name,
            'first_name'=>$this->first_name,
            'email'=>$this->email,
            'is_profile_completed'=>$this->is_profile_completed,
            'is_password_changed'=>$this->is_password_changed,
            /* 'mobile_number'=>$this->mobile_number,
            'access_token'=>$this->access_token,
            'profile_picture'=>$this->profile_picture, */
            'user_health_screen_one_details'=> !empty($this->userHealthScreenOneDetails) ? new UserHealthDetailScreenOneApiCollection($this->userHealthScreenOneDetails):"",
            'user_health_screen_two_details'=> !empty($this->userHealthScreenTwoDetails) ? new UserHealthDetailScreenTwoApiCollection($this->userHealthScreenTwoDetails):"",
            'user_health_screen_three_details'=> !empty($this->userHealthScreenThreeDetails) ? new UserHealthDetailScreenThreeApiCollection($this->userHealthScreenThreeDetails):"",
        ];
    }
}

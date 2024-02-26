<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserTrainerDetailApiCollection extends JsonResource
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
            'user_id' => $this->id,
            'name_prefix' => !empty($this->name_prefix) ? $this->name_prefix:"",
            'name' =>  !empty($this->first_name) ? $this->first_name:"",
            'email'=>$this->email,
            'is_profile_completed'=>$this->is_profile_completed,
            'is_password_changed'=>$this->is_password_changed,
            'mobile_number'=>$this->mobile_number,
            'access_token'=>$this->access_token,
            'profile_picture'=>$this->customer_picture,
            'expertise' => !empty($this->trainerDetail->expertise) ? $this->trainerDetail->expertise : "",
            'qualification_name' => !empty($this->trainerDetail->qualification_name) ? $this->trainerDetail->qualification_name : "",
            'introduction' => !empty($this->trainerDetail->intro) ? $this->trainerDetail->intro : "",
            'experience' => !empty($this->trainerDetail->experience) ? $this->trainerDetail->experience : "",
            'slot_select'=>!empty($this->trainerDetail->slot_select)?json_decode($this->trainerDetail->slot_select,true):[],
            'type'=>$this->type
        ];

       
    }
}

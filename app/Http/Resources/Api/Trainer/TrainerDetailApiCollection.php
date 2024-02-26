<?php

namespace App\Http\Resources\Api\Trainer;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Api\Customer\UserProfileApiCollection;
use App\Http\Resources\Api\Customer\UserProfileOtherInformationApiCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainerDetailApiCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       //return parent::toArray($request);

       return [
        'name_prefix' => $this->name_prefix,
        'name' => $this->first_name,
        'first_name'=>$this->first_name,
        'email'=>$this->email,
        'is_profile_completed'=>$this->is_profile_completed,
        'is_password_changed'=>$this->is_password_changed,
        'mobile_number'=>$this->mobile_number,
        'access_token'=>$this->access_token,
        'type'=>$this->type,
        'slot'=>!empty($this->trainerDetail->slot_select)?json_decode($this->trainerDetail->slot_select,true):[]

        //'profile_picture'=>$this->customer_picture,
        //'bank_cq'=>"ffffff",


        //'fitness'=>$this->fitness,
        //'physical_conditions'=>$this->physicalCondition,
        //'profile_details'=> !empty($this->profile) ? new UserProfileApiCollection($this->profile):(object)[],
        //'profile_other_details'=> !empty($this->profileOtherInformation) ? new UserProfileOtherInformationApiCollection($this->profileOtherInformation):(object)[],

    ];

    }
}



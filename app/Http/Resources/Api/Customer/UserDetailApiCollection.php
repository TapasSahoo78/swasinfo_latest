<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserDetailApiCollection extends JsonResource
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
            'id' => $this->id,
            'name' => $this->first_name,
            'first_name'=>$this->first_name,
            'email'=>$this->email,
            'is_profile_completed'=>$this->is_profile_completed,
            'is_password_changed'=>$this->is_password_changed,
            'mobile_number'=>$this->mobile_number,
            'access_token'=>$this->access_token,
            'profile_picture'=>$this->customer_picture,
            'fitness'=>$this->fitness,
            'physical_conditions'=>$this->physicalCondition,
            'profile_details'=> !empty($this->profile) ? new UserProfileApiCollection($this->profile):(object)[],
            'profile_other_details'=> !empty($this->profileOtherInformation) ? new UserProfileOtherInformationApiCollection($this->profileOtherInformation):(object)[],
            'is_advance'=>$this->is_advance,
            'is_subscribed'=>$this->is_subscribed,
            'subscribed_details'=> $this->subscribedDetails,
            'total_calorie'=> $this->total_calorie,
            'is_email'=>$this->is_email,
        ];
    }
}

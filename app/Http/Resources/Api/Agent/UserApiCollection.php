<?php

namespace App\Http\Resources\Api\Agent;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Agent\MfiApiCollection;
class UserApiCollection extends JsonResource
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
            // 'is_password_changed'=>$this->is_password_changed,
            'mobile_number'=>$this->mobile_number,
            // 'registration_number' => $this->registration_status,
            // 'login_id' => $this->login_id,
            'access_token'=>$this->access_token,
            'profile_picture'=>$this->profile_picture,
        ];
    }
}

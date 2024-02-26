<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserProfileOtherInformationApiCollection extends JsonResource
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
        'user_id'=>!empty($this->user_id)?$this->user_id:'',
        'do_you_have_any_allergies'=>!empty($this->do_you_have_any_allergies)?$this->do_you_have_any_allergies:'',
        'do_you_have_any_medical_condition'=>!empty($this->do_you_have_any_medical_condition)?$this->do_you_have_any_medical_condition:'',
        'diet_type'=>!empty($this->diet_type)?$this->diet_type:'',
        'allergies_type'=>!empty($this->allergies_type)?explode(',', $this->allergies_type):[],
        'medical_condition_type'=>!empty($this->medical_condition_type)?explode(',', $this->medical_condition_type):[]

    ];
}
}

<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserProfileApiCollection extends JsonResource
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
            'gender'=>!empty($this->gender)?$this->gender:'',
            'age'=>!empty($this->age)?$this->age:'',
            'height'=>!empty($this->height)?$this->height:'',
            'weight'=>!empty($this->weight)?$this->weight:'',
            'height_type'=>!empty($this->height)?$this->height:'',
            'weight_type'=>!empty($this->weight)?$this->weight:'',
            'target_weight'=>!empty($this->target_weight)?$this->target_weight:'',
            'guidance'=> !empty($this->guidance)?json_decode($this->guidance,true):'',
            'guidance_string'=> !empty($this->guidance)?implode(",",json_decode($this->guidance,true)):'',
            'bmi' => !empty($this->bmi)?$this->bmi:''

        ];
    }
}

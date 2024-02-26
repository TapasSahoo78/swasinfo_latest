<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FoodDetailsApiCollection extends JsonResource
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
            'food_id'=>!empty($this->food_id)?$this->food_id:'',
            'food_detail_id'=>!empty($this->id)?$this->id:'',
            'food_name'=>!empty($this->food_name)?$this->food_name:'',
            'status'=>$this->status,
            'details_image'=>$this->details_image,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
           
        ];
    }
}

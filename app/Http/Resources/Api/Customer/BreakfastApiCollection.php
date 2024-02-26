<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BreakfastApiCollection extends JsonResource
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
            'id'=>$this->id,
            'uuid'=>$this->uuid,
            'name'=>$this->name,
            'food_type'=>$this->food_type,
            'callories'=>$this->breakfast_callories,
            'carbs'=>$this->carbs,
            'proteins'=>$this->proteins,
            'fats'=>$this->fats,
            'fibre'=>$this->fibre,
            'food_make'=>$this->food_make,
            'food_suffix'=>$this->food_suffix,
            'quantity'=>$this->quantity,
            'is_optional'=>$this->is_optional,
            'status'=>$this->status,
            'breakfast_image'=>$this->breakfast_image,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            //'food_details'=> !empty($this->foodItemsDetails) ?  FoodDetailsApiCollection::collection($this->foodItemsDetails):(object)[],

        ];
    }
}

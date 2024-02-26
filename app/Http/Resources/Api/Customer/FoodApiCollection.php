<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FoodApiCollection extends JsonResource
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
            'name'=>$this->name,
            'food_type'=>$this->food_type,
            'quantity'=>$this->quantity,
            'food_make'=>$this->food_make,
            'food_suffix'=>$this->food_suffix,
            'breakfast_callories'=>$this->breakfast_callories,
            'lunch_callories'=>$this->lunch_callories,
            'dinner_callories'=>$this->dinner_callories,
            'snack_callories'=>$this->snack_callories,
            'carbs'=>$this->carbs,
            'proteins'=>$this->proteins,
            'fats'=>$this->fats,
            'fibre'=>$this->fibre
        ];
    }
}

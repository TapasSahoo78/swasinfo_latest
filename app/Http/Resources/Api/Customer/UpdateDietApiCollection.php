<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UpdateDietApiCollection extends JsonResource
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
            'gender' => $this->gender,
            'id' => $this->id,
            'uuid' => $this->uuid,
            'age_from'=>$this->age_from,
            'age_to'=>$this->age_to,
            'height_from'=>$this->height_from,
            'height_to'=>$this->height_to,
            'weight_from'=>$this->weight_from,
            'weight_to'=>$this->weight_to,
            'bmi'=>$this->bmi_from,
            'goal'=>$this->goal,
            'diet'=>$this->diet,
            'medical_condition'=>$this->medical_condition,
            'allergy'=>$this->allergy,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'breakfast'=> !empty($this->breakfast)?BreakfastApiCollection::collection($this->breakfast):[],
            'optional_breakfast'=> !empty($this->breakfasts)?BreakfastOptionalApiCollection::collection($this->breakfasts):[],
            'breakfastwater'=>$this->breakfastwater,
            'breakremark'=>$this->breakremark,
            'lunchwater'=>$this->breakfastlunch,
            'lunchremark'=>$this->lunchremark,
            'dinerwater'=>$this->breakfastdinner,
            'dinnerremarks'=>$this->dinnerremarks,
            'snekswater'=>$this->breakfastsnack,
            'snackremarks'=>$this->snackremarks,
        'lunch'=>!empty($this->lunch)? LunchApiCollection::collection($this->lunch):[],
            'optional_lunch'=>!empty($this->lunchs)? LunchOptionalApiCollection::collection($this->lunchs):[],
            'dinner'=>!empty($this->dinner)? DinnerApiCollection::collection($this->dinner):[],
            'optional_dinner'=>!empty($this->dinners)? DinnerOptionalApiCollection::collection($this->dinners):[],
            'snack'=>!empty($this->snack)? SnackApiCollection::collection($this->snack):[],
            'optional_snack'=>!empty($this->snacks)? SnackOptionalApiCollection::collection($this->snacks):[],
             'totalcalorie'=>$this->calorie,
             'protein'=>$this->protiens,
             'fibre'=>$this->fibre,
             'fats'=>$this->fats,
             'carbs'=>$this->carbs,
             
        ];
        
    }
}

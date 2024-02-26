<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DietApiCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //echo count($this->breakfasts);
        //dd($this->breakfasts);
        $filteredFoodsbreakfasts = $this->breakfasts->filter(function ($food) {
            return $food->food_type_option === $this->food_type_optionsend;
        });
        $filteredFoodsbreakfasts = $filteredFoodsbreakfasts->values();

        $filteredFoodslunch = $this->lunches->filter(function ($food) {
            return $food->food_type_option === $this->food_type_optionsend;
        });
        $filteredFoodslunch = $filteredFoodslunch->values();


        $filteredFoodsdinner = $this->dinners->filter(function ($food) {
            return $food->food_type_option === $this->food_type_optionsend;
        });
        $filteredFoodsdinner = $filteredFoodsdinner->values();


        $filteredFoodssnack = $this->snacks->filter(function ($food) {
            return $food->food_type_option === $this->food_type_optionsend;
        });
        $filteredFoodssnack = $filteredFoodssnack->values();
        //$this->breakfasts = $filteredFoods;
        //echo count($filteredFoods);
        //dd($filteredFoods);
        return [
            'food_type_optionsend'=>$this->food_type_optionsend,
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
            'breakfast'=> !empty($filteredFoodsbreakfasts)?BreakfastApiCollection::collection($filteredFoodsbreakfasts):[],
            'optional_breakfast'=> !empty($this->dietAnyBreakfasts)?BreakfastOptionalApiCollection::collection($this->dietAnyBreakfasts):[],
            'lunch'=>!empty($filteredFoodslunch)? LunchApiCollection::collection($filteredFoodslunch):[],
            'optional_lunch'=>!empty($this->dietAnyLunches)? LunchOptionalApiCollection::collection($this->dietAnyLunches):[],
            'dinner'=>!empty($filteredFoodsdinner)? DinnerApiCollection::collection($filteredFoodsdinner):[],
            'optional_dinner'=>!empty($this->dietAnyDinners)? DinnerOptionalApiCollection::collection($this->dietAnyDinners):[],
            'snack'=>!empty($filteredFoodssnack)? SnackApiCollection::collection($filteredFoodssnack):[],
            'optional_snack'=>!empty($this->dietAnySnacks)? SnackOptionalApiCollection::collection($this->dietAnySnacks):[],
            'breakfastwater'=>"",
            'breakremark'=>"",
            'lunchwater'=>"",
            'lunchremark'=>"",
            'dinerwater'=>"",
            'dinnerremarks'=>"",
            'snekswater'=>"",
            'snackremarks'=>"",
             'totalcalorie'=>$this->calorie,
             'protein'=>$this->protiens,
             'fibre'=>$this->fibre,
             'fats'=>$this->fats,
             'carbs'=>$this->carbs,
             'mydietitian'=>$this->mydietitian,
             'mytrainer'=>$this->mytrainer,
             
        ];
        
    }
}

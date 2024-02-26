<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserHealthDetailScreenOneApiCollection extends JsonResource
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
            'uuid' => $this->uuid,
            'sleep_schedule' => $this->sleep_schedule,
            'total_sleep_hours' => $this->total_sleep_hours,
            'is_followed_diet_plan' => $this->is_followed_diet_plan,
            'diet_plan_last_time' => $this->diet_plan_last_time,
            'is_followed_exercise_plan' => $this->is_followed_exercise_plan,
            'exercise_plan_last_time' => $this->exercise_plan_last_time,
            'any_physical_movement' => $this->any_physical_movement,
            'physical_movement_last_time' => $this->physical_movement_last_time,
            'water_intake_last_time' => $this->water_intake_last_time,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

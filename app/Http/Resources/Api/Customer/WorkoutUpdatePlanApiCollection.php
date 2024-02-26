<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkoutUpdatePlanApiCollection extends JsonResource
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
            'uuid' => $this->workout->uuid,
            'name'=>$this->workout->name,
            'workout_type'=>$this->workout_type,
            'image'=>$this->workout_image,
            'sets' =>!empty($this->sets) ? $this->sets : 0,
            'reps' =>!empty($this->reps) ? $this->reps : 0,
            'time' =>!empty($this->time) ? $this->time : 0,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];
    }
}

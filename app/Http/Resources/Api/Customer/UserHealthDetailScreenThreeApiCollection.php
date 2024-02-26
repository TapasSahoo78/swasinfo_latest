<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserHealthDetailScreenThreeApiCollection extends JsonResource
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
            'do_you_take_any_medication' => $this->do_you_take_any_medication,
            'have_you_been_recently_hospitalized' => $this->have_you_been_recently_hospitalized,
            'do_you_suffer_from_asthma' => $this->do_you_suffer_from_asthma,
            'do_you_have_high_uric_acid' => $this->do_you_have_high_uric_acid,
            'do_you_have_diabities' => $this->do_you_have_diabities,
            'do_you_have_high_cholesterol' => $this->do_you_have_high_cholesterol,
            'do_you_suffer_from_high_or_low_blood_pressure' => $this->do_you_suffer_from_high_or_low_blood_pressure,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

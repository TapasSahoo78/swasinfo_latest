<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserHealthDetailScreenTwoApiCollection extends JsonResource
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
            'do_you_get_tired_during_the_day' => $this->do_you_get_tired_during_the_day,
            'feel_drizzing_when_you_wakeup' => $this->feel_drizzing_when_you_wakeup,
            'how_much_do_you_smoke_in_a_day' => $this->how_much_do_you_smoke_in_a_day,
            'how_often_do_you_drink' => $this->how_often_do_you_drink,
            'what_do_you_usually_drink' => $this->what_do_you_usually_drink,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

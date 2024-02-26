<?php

namespace App\Http\Resources\Api\Agent\Purpose;

use Illuminate\Http\Resources\Json\JsonResource;

class PurposeCollection extends JsonResource
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
            'purpose_id' => $this->id,
            'name' => $this->name,
            'note'=>$this->note,
            'status'=>$this->status? "active" :"inactive",

        ];
    }
}

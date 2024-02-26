<?php

namespace App\Http\Resources\Mfi\Purpose;

use Illuminate\Http\Resources\Json\JsonResource;

class PurposenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'note' => $this->note
        ];
    }
}

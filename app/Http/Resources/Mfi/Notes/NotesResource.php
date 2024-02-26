<?php

namespace App\Http\Resources\Mfi\Notes;

use Illuminate\Http\Resources\Json\JsonResource;

class NotesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'enquiry_id' => $this->id,
            // 'uuid' => $this->uuid,
            'status' => $this->status,
            /* 'min_amount' => $this->min_amount,
            'max_amount' => $this->max_amount, */
        ];
    }
}

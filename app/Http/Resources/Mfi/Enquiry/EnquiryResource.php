<?php

namespace App\Http\Resources\Mfi\Enquiry;

use Illuminate\Http\Resources\Json\JsonResource;

class EnquiryResource extends JsonResource
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
            'id' => $this->id,
            'uuid' => $this->uuid,
            'min_amount' => $this->min_amount,
            'max_amount' => $this->max_amount,
            'message' => $this->message,
            'lead_id' => $this->lead?->uuid,
            'loan_id' => $this->loan?->uuid,
        ];
    }
}

<?php

namespace App\Http\Resources\Api\Customer;

use App\Models\GymCategory;
use App\Models\GymTrainerPersonalDetail;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GymBookingListCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $gymDetails = GymTrainerPersonalDetail::where([
            'user_id' => $this?->gymManage->user_id
        ])->first('gym_name');
        return [
            'booking_id' => $this?->id ?? '', // Use $this to access properties directly
            'user_name' => $this?->userDetails ? $this?->userDetails?->first_name . ' ' . $this?->userDetails?->last_name : '', // Concatenate first_name and last_name
            'gymCategory' => $this?->gymCategory?->name ?? '', // Handle potential null values
            'gymManage' => $gymDetails?->gym_name ?? '', // Handle potential null values
            'booking_date' => $this?->start_date ?? '',
            'timing' => $this?->timing ?? '',
            'status' => $this?->status ?? ''
        ];
    }
}

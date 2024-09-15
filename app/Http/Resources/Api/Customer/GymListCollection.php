<?php

namespace App\Http\Resources\Api\Customer;

use App\Models\GymCategory;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GymListCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Retrieve the available workout IDs from the gymCenterDetails (handle potential null values)
        $availableWorkoutIds = json_decode($this?->gymCenterDetails?->gym_category_ids ?? '[]', true);

        // Ensure $availableWorkoutIds is an array, even if decoding fails
        if (!is_array($availableWorkoutIds)) {
            $availableWorkoutIds = [];
        }

        // Query the categories table for matching IDs if any IDs are provided
        $workoutNames = !empty($availableWorkoutIds)
            ? GymCategory::whereIn('id', $availableWorkoutIds)->pluck('name')
            : collect();  // Return an empty collection if no IDs are available

        // Return the gym name and the available workout names
        return [
            'gym_id' => $this?->id ?? '',
            'gym_img' => url('uploads/' . $this?->gymPersonalDetails?->gym_logo),
            'gym_name' => $this?->gymPersonalDetails->gym_name ?? '',
            'available_workout' => $workoutNames->isNotEmpty() ? $workoutNames : ""
        ];
    }
}

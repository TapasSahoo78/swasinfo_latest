<?php

namespace App\Http\Resources\Api\Customer;

use App\Models\GymCategory;
use App\Models\GymDay;
use App\Models\GymFacilities;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Carbon;

class GymDetailsCollection extends JsonResource
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

        $facilitiesIds = json_decode($this?->gymCenterDetails?->facilities ?? '[]', true);

        // Ensure $facilitiesIds is an array, even if decoding fails
        if (!is_array($facilitiesIds)) {
            $facilitiesIds = [];
        }

        // Retrieve the available workout IDs from the gymCenterDetails (handle potential null values)
        $availableDays = json_decode($this?->gymCenterDetails?->days ?? '[]', true);

        // Ensure $availableWorkoutIds is an array, even if decoding fails
        if (!is_array($availableDays)) {
            $availableDays = [];
        }


        // Query the categories table for matching IDs if any IDs are provided
        $workoutNames = !empty($availableWorkoutIds)
            ? GymCategory::whereIn('id', $availableWorkoutIds)->pluck('name')
            : collect();  // Return an empty collection if no IDs are available

        // Query the categories table for matching IDs if any IDs are provided
        $facilitiesNames = !empty($facilitiesIds)
            ? GymFacilities::whereIn('id', $facilitiesIds)->pluck('name')
            : collect();  // Return an empty collection if no IDs are available
        // Query the categories table for matching IDs if any IDs are provided
        $daysNames = !empty($availableDays)
            ? GymDay::whereIn('id', $availableDays)->pluck('name')
            : collect();  // Return an empty collection if no IDs are available

        $startTime = Carbon::parse($this?->gymCenterDetails?->start_time)->format('h:i A');
        $endTime = Carbon::parse($this?->gymCenterDetails?->end_time)->format('h:i A');

        $timing = $startTime . ' to ' . $endTime;

        // Return the gym name and the available workout names
        return [
            'gym_id' => $this?->id ?? '',
            'gym_name' => $this?->gymPersonalDetails->gym_name ?? '',
            'gym_img' => url('uploads/' . $this?->gymPersonalDetails?->gym_logo),
            'timing' => $timing ?? "",
            'days' => $daysNames->isNotEmpty() ? formatFirstAndLastDay($daysNames) : "",

            'available_workout' => $workoutNames->isNotEmpty() ? $workoutNames : "",
            'facilities' => $facilitiesNames->isNotEmpty() ? $facilitiesNames : "",
            'about_us' =>  $this?->gymCenterDetails?->about_us ?? "",

            'all_slots' => generateTimeSlots($startTime, $endTime)
        ];
    }
}

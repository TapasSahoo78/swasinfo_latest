<?php

namespace App\Http\Resources\Mfi\Branch;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchOprationAreaResource extends JsonResource
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
            'branch_id' => $this->id,
            'branch_uuid' => $this->uuid,
            'branch_opreation_id' =>!empty( $this->oprationArea) ?  $this->oprationArea->id : "",
            'zone_name' =>!empty( $this->oprationArea) ?  $this->oprationArea->zone_name : "",
            'mfi_id' =>!empty( $this->oprationArea) ?  $this->oprationArea->mfi_id : "",
            'country' =>$this->country_name,
            'zip_codes' =>!empty( $this->oprationArea) ?  json_decode($this->oprationArea->zip_codes,TRUE) : "",
            'states_name' =>$this->state_name,
            'cities_name' =>!empty( $this->oprationArea) ?  json_decode($this->oprationArea->cities_name,TRUE) : ""
        ];
    }
}

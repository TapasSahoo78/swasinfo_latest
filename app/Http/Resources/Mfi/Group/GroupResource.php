<?php

namespace App\Http\Resources\Mfi\Group;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
        $agentsId = $this->agents->pluck('id')->toArray();
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'code' => $this->code,
            'branch_id' => $this->branch_id,
            'leader_user_id' => $this->leader_user_id,
            'user_id' => $agentsId,
            'country_name' => $this->country_name,
            'state_name' => $this->state_name,
            'city_name' => $this->city_name,
            'zip_code' => $this->zip_code,
            'full_address' => $this->full_address,
            'landmark' => $this->landmark,
            'remarks' => $this->remarks
        ];
    }
}

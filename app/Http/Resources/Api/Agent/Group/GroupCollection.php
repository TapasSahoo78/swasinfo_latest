<?php

namespace App\Http\Resources\Api\Agent\Group;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GroupCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'group_id'=>$this->id,
            'code'=>$this->code,
            'leader_user_id'=>$this->leader_user_id,
            'leader_user_name'=>!empty($this->user) ? $this->user->first_name :"",
            ];
    }
}

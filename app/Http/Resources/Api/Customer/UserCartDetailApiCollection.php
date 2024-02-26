<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCartDetailApiCollection extends JsonResource
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
            'id' => !empty($this->product->id) ? $this->product->id:"",
            'qty' => $this->quantity,
            'name' =>  !empty($this->product->name) ? $this->$this->product->name:"",
            'images'=>$this->image,
            'discount'=>!empty($this->product->discount) ? $this->$this->product->discount:"",
            'price'=>$this->price_per_quantity
          
        ];

       
    }
}

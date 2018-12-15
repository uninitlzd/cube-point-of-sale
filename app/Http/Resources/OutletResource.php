<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class OutletResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'products' => ProductResource::collection($this->whenLoaded('products'))
        ];
    }
}

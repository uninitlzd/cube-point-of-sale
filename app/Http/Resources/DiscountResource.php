<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class DiscountResource extends Resource
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
            'shop_id' => $this->shop_id,
            'name' => $this->name,
            'percentage' => (double) $this->percentage,
            'deleted_at' => $this->deleted_at,
            'products' => ProductResource::collection($this->whenLoaded('products'))
        ];
    }
}

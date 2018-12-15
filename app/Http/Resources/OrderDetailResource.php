<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class OrderDetailResource extends Resource
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
            "id" => $this->id,
            "product_id" => $this->product_id,
			"quantity" => $this->quantity,
			"selling_price" => $this->selling_price,
			"sub_total" => (int) $this->sub_total,
			"discounted" => $this->discounted
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountProductResource extends JsonResource
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
            'description' => $this->description,
            'purchase_price' => $this->purchase_price,
            $this->mergeWhen($this->hasDiscount(), [
                'selling_price' => (1 - $this->discount->first()['percentage'] * 0.01) * $this->selling_price,
                'original_selling_price' => $this->selling_price,
            ]),
            'selling_price' => $this->selling_price,
            'original_selling_price' => $this->selling_price,
            'image' => $this->image,
        ];
    }
}

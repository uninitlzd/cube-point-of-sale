<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id' => (int) $this->id,
            'name' => $this->name,
            'category_id' => (int) $this->category_id,
            'description' => $this->description,
            'purchase_price' => (int) $this->purchase_price,
            $this->mergeWhen($this->hasDiscount(), [
                'original_selling_price' => (int) $this->selling_price,
                'selling_price' => (int) (1 - $this->discount['percentage'] * 0.01) * $this->selling_price,
            ]),
            'selling_price' => (int) $this->selling_price,
            'stockable' => $this->stockable,
            'image' => $this->image,
            'has_discount' => ($this->hasDiscount()),
            'discounts' => DiscountResource::collection($this->whenLoaded('discounts')),
            'stocks' => ProductStockResource::collection($this->whenLoaded('stocks'))
        ];
    }
}

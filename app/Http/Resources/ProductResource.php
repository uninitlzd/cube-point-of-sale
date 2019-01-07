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
            'id' => $this->id,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'purchase_price' => $this->purchase_price,
            $this->mergeWhen($this->hasDiscount(), [
                'original_selling_price' => $this->selling_price,
                'selling_price' => (1 - $this->discounts->first()['percentage'] * 0.01) * $this->selling_price,
            ]),
            'selling_price' => $this->selling_price,
            'stockable' => $this->stockable,
            'image' => $this->image,
            'has_discount' => ($this->hasDiscount()),
            'discounts' => DiscountResource::collection($this->whenLoaded('discounts')),
            'stock' => ProductStockResource::collection($this->whenLoaded('stocks'))
        ];
    }
}

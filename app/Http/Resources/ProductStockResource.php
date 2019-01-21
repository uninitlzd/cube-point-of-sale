<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductStockResource extends JsonResource
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
            'shop_outlet_id' => (int) $this->shop_outlet_id,
            'product_id' => (int) $this->product_id,
            'amount' => (int) $this->number_of_stock,
            'unit' => $this->unit,
            'out_of_stock' => ($this->product->stockable) ? ($this->number_of_stock == 0) : false,
            'outlet' => $this->whenLoaded('outlet')
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MaterialResource extends Resource
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
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'supplier' => $this->supplier,
            'purchase_date' => $this->purchase_date
        ];
    }
}

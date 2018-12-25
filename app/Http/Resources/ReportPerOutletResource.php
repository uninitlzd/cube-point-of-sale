<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ReportPerOutletResource extends Resource
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
            'is_main_branch' => $this->is_main_branch,
            'orders' => $this->whenLoaded('orders'),
            'gross_profit_sum' => $this->orders->sum('gross_profit'),
            'items_sold' => $this->orders->sum('quantity_sum'),
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Helpers\Money;
use App\Models\Member;
use App\Models\Order;
use App\Models\TransactionType;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'shop_outlet_id' => $this->shop_outlet_id,
            'transaction_type' => new TransactionTypeResource($this->whenLoaded('transactionType')),
            'member_id' => $this->member_id,
            'customer_name' => $this->customer_name,
            'order_details' => OrderDetailResource::collection($this->whenLoaded('details')),
            'order_total' => $this->order_total,
            'tax' => $this->tax,
            'total' => $this->total,
            'paid' => $this->paid
        ];
    }
}

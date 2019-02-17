<?php

namespace App\Http\Resources;

use App\Helpers\Money;
use App\Models\Member;
use App\Models\Order;
use App\Models\CustomerType;
use Carbon\Carbon;
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
            'amount' => $this->amount,
            'order_details' => OrderDetailResource::collection($this->whenLoaded('details')),
            'order_total' => Money::format($this->order_total),
            'tax' => Money::format($this->tax),
            'total' => Money::format($this->total),
            'paid' => Money::format($this->paid),
            'created_at' => Carbon::parse($this->created_at)->toFormattedDateString()
        ];
    }
}

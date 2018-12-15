<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelFakeId\RoutesWithFakeIds;

class Order extends Model
{
    protected $guarded = ['id'];

    public function outlet()
    {
        return $this->belongsTo(ShopOutlet::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function scopeCreatedBetween(Builder $query, $dateStart, $dateEnd)
    {
        return $query->whereBetween('orders.created_at', [$dateStart, $dateEnd]);
    }

    public function scopeCreatedInMonth(Builder $query, $month = null)
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = (is_null($month)) ? $now->month : (int) $month;

        return $query->whereMonth('orders.created_at', $month);
    }
}

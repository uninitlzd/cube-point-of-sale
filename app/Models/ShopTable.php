<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelFakeId\RoutesWithFakeIds;

class ShopTable extends Model
{
    use RoutesWithFakeIds;

    protected $guarded = ['id'];

    public function shopOutlet()
    {
        return $this->belongsTo(ShopOutlet::class);
    }
}

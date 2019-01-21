<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function shopOutlet()
    {
        return $this->belongsTo(ShopOutlet::class, 'shop_outlet_id', 'id');
    }
}

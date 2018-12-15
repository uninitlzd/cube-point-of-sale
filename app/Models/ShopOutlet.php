<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelFakeId\RoutesWithFakeIds;

class ShopOutlet extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function tables()
    {
        return $this->hasMany(ShopTable::class);
    }

    public function users()
    {
        return $this->belongsToMany(ShopOutlet::class, 'user_roles', 'shop_branch_id', 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_stocks')->withTimestamps();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

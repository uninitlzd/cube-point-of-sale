<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }


    public function stocks()
    {
        return $this->hasMany(ProductStock::class, 'product_id', 'id');
    }

    public function scopeStockOfOutlet($outletId)
    {
        return self::stocks()->where('shop_outlet_id', $outletId);
    }

    public function outlets()
    {
        return $this->belongsToMany(ShopOutlet::class, 'product_stocks');
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'product_discounts', 'product_id', 'discount_id');
    }

    public function hasDiscount()
    {
        return ($this->discounts->count());
    }
}

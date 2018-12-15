<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelFakeId\RoutesWithFakeIds;

class Shop extends Model
{
    protected $guarded = ['id'];

    public function outlets()
    {
        return $this->hasMany(ShopOutlet::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'user_roles')
            ->withPivot('shop_id','shop_outlet_id', 'role_id')
            ->wherePivot('role_id', '!=', 1);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}

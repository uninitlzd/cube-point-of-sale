<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelFakeId\RoutesWithFakeIds;

class ProductStock extends Model
{
    use RoutesWithFakeIds;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function outlet()
    {
        return $this->belongsToMany(ShopOutlet::class);
    }
}

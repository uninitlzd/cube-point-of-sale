<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelFakeId\RoutesWithFakeIds;

class Category extends Model
{
    protected $guarded = ['id'];

    public function store()
    {
        return $this->belongsTo(Shop::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class
        );
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}

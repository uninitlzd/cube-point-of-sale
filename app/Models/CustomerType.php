<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    protected $guarded = ['id'];

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}

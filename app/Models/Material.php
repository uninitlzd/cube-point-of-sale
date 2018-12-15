<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $guarded = ['id'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}

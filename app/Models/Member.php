<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function customerType()
    {
        return $this->belongsTo(CustomerType::class);
    }
}

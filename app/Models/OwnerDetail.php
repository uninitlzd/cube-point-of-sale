<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelFakeId\RoutesWithFakeIds;

class OwnerDetail extends Model
{
    use RoutesWithFakeIds;

    protected $guarded = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

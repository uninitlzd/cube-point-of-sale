<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Propaganistas\LaravelFakeId\RoutesWithFakeIds;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'id', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function getImageAttribute($value)
    {
        if (is_null($value)) {
            return asset('images/user.png');
        }

        return $value;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')
            ->withPivot('shop_id','shop_outlet_id');
    }

    public function role()
    {
        return $this->roles()->first();
    }

    public function employee()
    {

    }

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function outlets()
    {
        return $this->belongsToMany(ShopOutlet::class, 'user_roles', 'user_id', 'shop_outlet_id');
    }

    public function getIdAttribute($value)
    {
        return $value;
    }

    public function ownerDetail()
    {
        return $this->hasOne(OwnerDetail::class);
    }

    /**
     * @param array $roleName
     * @return bool
     */
    public function hasRole($role)
    {
        return !is_null($this->roles->where('name', $role)->first());
    }

    public function hasAnyRole($roles)
    {
        return !is_null($this->roles->whereIn('name', $roles)->first());
    }

    public function isOwner()
    {
        return $this->hasRole('owner');
    }

    public function hasShop()
    {
        return !is_null($this->shop);
    }

    public function hasProducts()
    {
        if (!is_null($this->hasShop())) {
            return false;
        }

        return !is_null($this->shop->products);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Eloquent Model method
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const OWNER = 'owner';
    const CASHIER = 'cashier';
    const OUTLET_SUPERVISOR = 'outlet_supervisor';
    const TYPE = [
        self::OWNER => 1,
        self::CASHIER => 2,
        self::OUTLET_SUPERVISOR => 3
    ];

    public static $availableRoles = [self::OWNER => 1, self::CASHIER => 2, self::OUTLET_SUPERVISOR];

    /**
     * @return array
     */
    public static function getAvailableRoles(): array
    {
        return self::$availableRoles;
    }

    public static function getRoleById(int $id): string
    {
        foreach (self::getAvailableRoles() as $roleName => $roleId) {
            if ($roleId == $id) {
                return $roleName;
            }
        }
    }

    public static function getRoleIdByName(string $name): int
    {
        foreach (self::getAvailableRoles() as $roleName => $roleId) {
            if ($roleName == $name) {
                return $roleId;
            }
        }
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function shopOutlet()
    {
        return $this->belongsTo(ShopOutlet::class, 'shop_outlet_id', 'id');
    }
}

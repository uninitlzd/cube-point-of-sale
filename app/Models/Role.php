<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const OWNER = 'owner';
    const CASHIER = 'cashier';
    const TYPE = [
        self::OWNER => 1,
        self::CASHIER => 2
    ];

    public static $availableRoles = [self::OWNER => 1, self::CASHIER => 2];

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
}

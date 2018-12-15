<?php

use App\Models\OwnerDetail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner = User::create([
            'name'      => 'Admin',
            'email'     => 'admin@pos.com',
            'password'  => 'secret'
        ]);

        $owner->roles()->attach(Role::getRoleIdByName(Role::OWNER));
        $owner->ownerDetail()->save(new OwnerDetail([
            'number_of_outlet' => 0,
            'number_of_employee' => 0
        ]));
    }
}

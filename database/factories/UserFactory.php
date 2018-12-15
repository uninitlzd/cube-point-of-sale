<?php

use App\Models\Role;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('secret'), // secret
        'remember_token' => str_random(10),
    ];
});

$factory->state(User::class, 'owner', function () {
    return [];
});

$factory->state(User::class, 'cashier', function () {
    return [];
});

$factory->afterCreatingstate(User::class, 'owner', function ($user, $faker) {
    $role = factory(Role::class)->create([
        'id' => 1,
        'name' => 'owner'
    ]);

    return $user->roles()->save($role);
});


$factory->afterCreatingState(User::class, 'cashier', function ($user, $faker) {
    return $user->roles()->attach(factory(Role::class)->state('cashier')->create());
});

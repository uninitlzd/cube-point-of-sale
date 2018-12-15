<?php

use App\Models\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'id' => 1,
        'name' => 'owner'
    ];
});


$factory->state(Role::class, 'owner', [
    'id'    => 1,
    'name'  => 'owner'
]);

$factory->state(Role::class, 'cashier', [
    'id'    => 2,
    'name'  => 'cashier'
]);

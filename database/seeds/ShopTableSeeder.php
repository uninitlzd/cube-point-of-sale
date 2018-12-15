<?php

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;

class ShopTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        $user->shop()->save(new Shop([
            'name' => 'Starbak',
            'type' => 2
        ]));
    }
}

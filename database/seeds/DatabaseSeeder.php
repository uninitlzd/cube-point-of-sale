<?php

use App\Models\OwnerDetail;
use App\Models\Role;
use App\Models\Shop;
use App\Models\CustomerType;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        UserRole::truncate();
        User::truncate();
        Shop::truncate();
        OwnerDetail::truncate();
        CustomerType::truncate();
        Schema::enableForeignKeyConstraints();

        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ShopTableSeeder::class);
        $this->call(TransactionTypesSeeder::class);
    }
}

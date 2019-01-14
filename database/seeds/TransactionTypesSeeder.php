<?php

use App\Models\CustomerType;
use Illuminate\Database\Seeder;

class TransactionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerType::create([
            'name' => 'Regular',
            'discount_percentage' => 0,
        ]);

        CustomerType::create([
            'name' => 'Member',
            'discount_percentage' => 5,
        ]);
    }
}

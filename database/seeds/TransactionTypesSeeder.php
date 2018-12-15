<?php

use App\Models\TransactionType;
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
        TransactionType::create([
            'name' => 'Regular',
            'discount_percentage' => 0,
        ]);

        TransactionType::create([
            'name' => 'Member',
            'discount_percentage' => 5,
        ]);
    }
}

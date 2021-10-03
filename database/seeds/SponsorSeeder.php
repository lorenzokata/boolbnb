<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sponsors')->insert([
            'time_span' => 24,
            'price' => 2.99,
            'name' => 'Silver',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sponsors')->insert([
            'time_span' => 72,
            'price' => 5.99,
            'name' => 'Gold',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sponsors')->insert([
            'time_span' => 144,
            'price' => 9.99,
            'name' => 'Platinum',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

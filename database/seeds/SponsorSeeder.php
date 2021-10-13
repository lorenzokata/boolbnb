<?php

use Illuminate\Database\er;
use Illuminate\Support\Facades\DB;

class Sponsorer extends er
{
    /**
     * Run the database s.
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

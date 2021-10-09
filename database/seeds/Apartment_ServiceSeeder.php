<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Apartment_ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10; $i++) { 

            DB::table('apartment_service')->insert([
                'apartment_id' => $i+1,
                'service_id' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }
    }
}

<?php

use Illuminate\Database\er;
use Illuminate\Support\Facades\DB;

class Apartment_Serviceer extends er
{
    /**
     * Run the database s.
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

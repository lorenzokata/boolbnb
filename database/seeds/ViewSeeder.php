<?php

use Illuminate\Database\er;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class Viewer extends er
{
    /**
     * Run the database s.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 10; $i++) { 

            DB::table('views')->insert([
                'apartment_id' => rand(1, 10),
                'ip_user' => $faker->ipv4(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }
    }
}

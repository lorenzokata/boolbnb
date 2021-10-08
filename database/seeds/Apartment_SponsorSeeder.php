<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class Apartment_SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 4; $i++) { 

            DB::table('apartment_sponsor')->insert([
                'apartment_id' => $i+2,
                'sponsor_id' => 1,
                'date_start' => now(),
                'date_end' => $faker->dateTimeInInterval('0 week', '+3 week'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }
    }
}

<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 10; $i++) { 

            DB::table('services')->insert([
                'name' => $faker->words(2, true),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }
    }
}

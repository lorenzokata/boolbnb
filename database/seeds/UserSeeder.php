<?php

use Illuminate\Database\er;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;

class Userer extends er
{
    /**
     * Run the database s.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //create 10 faker
        for ($i=0; $i < 10; $i++) { 
            
            DB::table('users')->insert([
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'email' => $faker->email,
                'password' => Hash::make('password'),
                'birth_date' => $faker->date,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 10; $i++) { 

            DB::table('messages')->insert([
                'apartment_id' => rand(1,10),
                'sender_email' => $faker->email,
                'sender_fullname' => $faker->name,
                'msg' => $faker->text,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }
    }
}

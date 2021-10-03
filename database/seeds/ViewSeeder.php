<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
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

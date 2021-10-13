<?php

use Illuminate\Database\er;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Apartment;

class Apartmenter extends er
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
            
            //creo instaza model
            $newApartment = new Apartment;

            //inseriamo i dati
            $newApartment->user_id = 1;
            $newApartment->title = $faker->sentence;
            $newApartment->description = $faker->sentence;
            $newApartment->n_rooms = 1;
            $newApartment->n_beds = 1;
            $newApartment->n_baths = 1;
            $newApartment->square_meters = 1;
            $newApartment->lat = $faker->latitude;
            $newApartment->lon = $faker->longitude;
            $newApartment->address = $faker->address;
            $newApartment->visible = true;
            // $string = $newApartment->title. $newApartment->id;
            $newApartment->slug = Str::of($newApartment->title . ' ' . $newApartment->user_id)->slug('-');

            //salvo i dati
            $newApartment->save();
        }
    }
}

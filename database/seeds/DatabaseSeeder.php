<?php

use Illuminate\Database\er;
use Illuminate\Support\Facades\DB;

class Databaseer extends er
{
    /**
     *  the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            Userer::class,
            Apartmenter::class,
            Sponsorer::class,
            Serviceer::class,
            Messageer::class,
            Viewer::class,
            Apartment_Sponsorer::class,
            Apartment_Serviceer::class
        ]);
    }

}
<?php

use Illuminate\Database\er;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class Serviceer extends er
{
    /**
     * Run the database s.
     *
     * @return void
     */
    public function run(Faker $faker)
    {   
        $array_servizi=['WiFi', 'Posto macchina', 'Piscina', 'Portineria', 'Sauna', 'Vista mare', '', 'Prodotti per la pulizia', 'Sapone per il corpo', 'Bidet', 'Acqua calda', 'Gel doccia', 'Appendiabiti', 'Biancheria da letto', 'Cuscini e coperte extra', 'Tende oscuranti', 'Ferro da stiro', 'TV', 'Libri e materiale di lettura', 'Raccomandazioni sui babysitter', 'Climatizzatore', 'Riscaldamento', 'Allarme antincendio', 'Rilevatore di monossido di carbonio', 'Estintore', 'Kit di pronto soccorso', 'Spazio di lavoro dedicato', 'Cucina', 'Frigorifero', 'Forno a microonde'];
        for ($i=0; $i < sizeof($array_servizi); $i++) { 

            DB::table('services')->insert([
                'name' => $array_servizi[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }
    }
}

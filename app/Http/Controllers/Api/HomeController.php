<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Apartment;
use App\Sponsor;
use App\Service;

class HomeController extends Controller
{
    public function dashboard($userId)
    {
        // controllare gli appartamenti che hanno come user_id = $userId
        $apartments = Apartment::where('user_id', $userId)->get();

        // $sponsored_apartments = [];
        // $not_sponsored_apartments = [];

        // $now = Carbon::now()->toDateTimeString();
        
        // possibile funzione helper
        // da convertire in query di laravel
        // foreach($apartments as $apartment){
        //     $semaforo=false;
        //     foreach ($apartment->sponsors as $sponsor) {

        //         if ($sponsor->pivot->date_end > $now) {
        //             array_push($sponsored_apartments, $apartment);
        //             $semaforo = true;
        //             break;
        //         }
        //     };
        //     if($semaforo == false){

                // array_push($not_sponsored_apartments, $apartment);
            // }
        // }

        return response()->json([
            'success' => true,
            'results' => [
                // 'sponsored_apartments' => $sponsored_apartments,
                'apartments' => $apartments
            ]
        ]);
    }

    public function home($userInput, $radius, $n_beds, $n_rooms, $filterS)
    {
        if($filterS != 'null'){
            $filter_list = explode('%', $filterS);
        }else{
            $filter_list = 'null';
        }
        ;
        
        // dati per chiamata Geocode
        $key = 'iYutMJyrnVArnI296DDnCsP4ZX15GiW2';
        $base_url = 'https://api.tomtom.com/search/2/geocode/';
        $complete_url = $base_url . Str::slug(trim($userInput), '%20') . '.json' . '?key=' . $key;

        // chiamata Geocode
        $response = Http::withOptions(['verify' => false])->get($complete_url);
        $response = $response->json();

        // lat e lon dei punto di ricerca
        $lat_center = $response['results'][0]['position']['lat'];
        $lon_center = $response['results'][0]['position']['lon'];

        // creazione JSON (con lat e lon del db)

        $apartments = Apartment::all();

        $poi_list = [];

        foreach ($apartments as $apartment) {

            $array = [
                'poi' =>
                ['name' => $apartment->id],
                'position' =>
                ['lat' => $apartment->lat, 'lon' => $apartment->lon]
            ];

            array_push($poi_list, $array);
        }

        // dati per chiamata geometryList
        $key = 'iYutMJyrnVArnI296DDnCsP4ZX15GiW2';
        $base_url = 'https://api.tomtom.com/search/2/geometryFilter.json';
        // il raggio della ricerca è espresso in metri
        $geometry_list = ["type" => "CIRCLE", "position" => $lat_center . ',' . $lon_center, "radius" => (int)$radius];
        $geometry_list = json_encode($geometry_list);
        $poi_list = json_encode($poi_list);
        $complete_url = $base_url . '?geometryList=[' . $geometry_list . ']&poiList=' . $poi_list . '&key=' . $key;


        // chiamata Geocode
        $response = Http::withOptions(['verify' => false])->get($complete_url);
        $response = $response->json();

        // cercare nella tabella ponte l'ID dell'appartamento
        $apartments = [];
        // $sponsored_apartments = [];

        $now = Carbon::now()->toDateTimeString();

        foreach ($response['results'] as $item) {

            $apartment = Apartment::where([
                ['id', $item['poi']['name']],
                ['n_beds', '>=', intval($n_beds)],
                ['n_rooms', '>=', intval($n_rooms)]
            ])->first();

            if(is_null($apartment)){
                continue;
            };


            if($filter_list != 'null'){
                $app_services = [];

                foreach ($apartment->services as $service) {

                    array_push($app_services, $service->id);
                };
                $diff = array_diff($filter_list, $app_services);


                if ($diff) {

                    continue;
                }

            }

            $distance = getDistanceBetweenPoints($lat_center, $lon_center, $apartment->lat, $apartment->lon);

            $element = [
                'apartment' => $apartment,
                'distance' => $distance
            ];
            // $semaforo = false;



            // foreach ($apartment->sponsors as $sponsor) {

            //     if ($sponsor->pivot->date_end > $now) {
            //         $semaforo = true;
            //         array_push($sponsored_apartments, $element);
            //         break;
            //     }
            // };
            // if($semaforo == false){

                array_push($apartments, $element);
            // }
            
        };

        // array sorting
        $distance = [];
        foreach ($apartments as $key => $row) {

            $distance[$key] = $row['distance'];
        }
        array_multisort($distance, SORT_ASC, $apartments);

        $distance = [];
        // foreach ($sponsored_apartments as $key => $row) {

        //     $distance[$key] = $row['distance'];
        // }
        // array_multisort($distance, SORT_ASC, $sponsored_apartments);

        $services = Service::all();

        return response()->json([
            'success' => true,
            'results' => [
                // 'sponsored_apartments' => $sponsored_apartments,
                'apartments' => $apartments,
                'services' => $services,
            ]
        ]);
    }

    public function getTrending(){
        // funzione query per ottenere lista di appartamenti sponsorizzati
        $now = Carbon::now();
        $now = $now->toDateTimeString();
        $sponsored_apartments = DB::table('apartments')
                                ->leftJoin('apartment_sponsor', 'apartments.id', '=', 'apartment_sponsor.apartment_id')
                                ->where('apartment_sponsor.date_end', '>', $now )
                                ->select('apartments.*')
                                ->groupBy('apartments.id')
                                ->get();

        return response()->json([
            'success' => true,
            'results' => [
                'sponsored_apartments' => $sponsored_apartments,
            ]
        ]);
    }
}
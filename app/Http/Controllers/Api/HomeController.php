<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Apartment;
use App\Sponsor;

class HomeController extends Controller
{
    public function dashboard()
    {
        //
    }

    public function home($userInput)
    {

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
        $geometry_list = ["type" => "CIRCLE", "position" => $lat_center . ',' . $lon_center, "radius" => 1000000000000000];
        $geometry_list = json_encode($geometry_list);
        $poi_list = json_encode($poi_list);
        $complete_url = $base_url . '?geometryList=[' . $geometry_list . ']&poiList=' . $poi_list . '&key=' . $key;

        
        // chiamata Geocode
        $response = Http::withOptions(['verify' => false])->get($complete_url);
        $response = $response->json();

        // cercare nella tabella ponte l'ID dell'appartamento
        $apartments = [];
        $sponsored_apartments = [];
    
        $now = Carbon::now();
        $now = $now->toDateTimeString();

        foreach ($response['results'] as $item) {
            $apartment = Apartment::where('id', $item['poi']['name'])->first();

            foreach ($apartment->sponsors as $sponsor) {
              
                if($sponsor->pivot->date_end > $now){
                    // dump($sponsor->pivot->date_end);
                    array_push($sponsored_apartments, $apartment);
                    break;
                }

            };
            array_push($apartments, $apartment);
            
        };

        // dump($apartments);           array dei risultati non sponsorizzati
        // dd($sponsored_apartments);             array dai risultati sponsorizzati

        return response()->json([
            'success' => true,
            'results' => [
                'sponsored_apartments' => $sponsored_apartments,
                'apartments' => $apartments
            ]
        ]);
    }
}

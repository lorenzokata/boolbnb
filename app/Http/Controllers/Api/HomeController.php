<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Apartment;

class HomeController extends Controller
{
    public function dashboard(){
        //
    }

    public function home(Request $request){
        
        // preleriamo la stringa dal form Home.vue
        $data = $request->all();
        $userInput = trim($data['userInput']);
        
        // dati per chiamata Geocode
        $key = 'iYutMJyrnVArnI296DDnCsP4ZX15GiW2';
        $base_url = 'https://api.tomtom.com/search/2/geocode/';
        $complete_url = $base_url . Str::slug($userInput , '%20') . '.json' . '?key=' . $key;

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
            
            $id = $apartment->id;
            $lat = $apartment->lat;
            $lon = $apartment->lon;
            
            $array = [
                    'poi' => 
                        ['name' => $id] ,
                    'position' => 
                        ['lat' => $lat , 'lon' => $lon]
            ];

            array_push( $poi_list , $array);
    
        }

        // dati per chiamata geometryList
        $key = 'iYutMJyrnVArnI296DDnCsP4ZX15GiW2';
        $base_url = 'https://api.tomtom.com/search/2/geometryFilter.json';
        $geometry_list = ["type" => "CIRCLE", "position" => $lat_center . ',' . $lon_center, "radius" => 1000000];
        $geometry_list = json_encode($geometry_list);
        $poi_list = json_encode($poi_list);
        $complete_url = $base_url . '?geometryList=[' . $geometry_list . ']&poiList=' . $poi_list . '&key=' . $key;

        dump($complete_url);
        dump($geometry_list);
        dump($poi_list);
        
        // chiamata Geocode
        $response = Http::withOptions(['verify' => false])->get($complete_url);

        $response = $response->json();        
        dump($response);

        // confrontare id della risposta API con id appartamenti in db e fornirli alla view SearchResults.vue


    }
}

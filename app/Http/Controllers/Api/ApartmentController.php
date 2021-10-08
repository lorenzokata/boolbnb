<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

// import model
use App\Service;
use App\Apartment;

class ApartmentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();

        return response()->json([
            'success' => true,
            'results' => $services
        ]);

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // implementare storage immagini

        // validazioni
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'n_rooms' => 'required',
            'n_beds' => 'required',
            'n_baths' => 'required',
            'square_meters' => 'required',
            'address' => 'required',
            'visible' => 'nullable',
            'image' => 'nullable|image'
        ]);
        
        // salvo la request
        $data = $request->all();
        // dd($data);

        // scusa mamma
        if($data['visible'] == 'on'){
            $data['visible'] = 1;
        }else{
            $data['visible'] = 0;
        }
       

        // // creare istanza del model Apartment
        $newApartment = new Apartment();

        // GESTIONE SLUG
        $slug = Str::slug($data['title'],'-');

        $slug_base = $slug;
        
        $slug_presente = Apartment::where('slug', $slug)->first();

        $counter = 1;

        while($slug_presente){

            // probabilmente inutile
            // $slug = $slug_base . '-' .$counter;
            // sostituito con questo
            $slug = $slug . '-' .$counter;

            $slug_presente = Apartment::where('slug', $slug)->first();

            $counter++;
        }

        $newApartment->slug = $slug;

        // gestione imgs
        if(array_key_exists('image',$data)){
            $imgs_path = Storage::put('images', $data['image']);

            $data['imgs'] = $imgs_path;
        }

        // CONVERSIONE INDIRIZZO IN LAT LOT CON API TOMTOM

        $address = $data['address'];
        $key = 'iYutMJyrnVArnI296DDnCsP4ZX15GiW2';
        

        // url composer
        $base_url = 'https://api.tomtom.com/search/2/search/';
        
        
        $complete_url = $base_url . Str::slug(trim($address) , '%20') . '.json' . '?key=' . $key;
    
        $response = Http::withOptions(['verify' => false])->get($complete_url);
        
        $response = $response->json();

        // prendo lat e lon dalla risposta di tom tom
        $lat = $response['results'][0]['position']['lat'];
        $lon = $response['results'][0]['position']['lon'];


        $newApartment->lat = $lat;
        $newApartment->lon = $lon;

        $newApartment->fill($data);

        $newApartment->save();
        
        if(array_key_exists('services' ,$data)){
            $newApartment->services()->attach($data['SelectedServices']);
        }
        

        return Redirect::to('/dashboard');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apartment = Apartment::where('id', $slug)->first();

        if($apartment->imgs){
            $apartment->imgs = url('storage/' . $apartment->imgs);
        }

        return response()->json([
            'success' => true,
            'results' => $apartment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        // dd($slug);
        // $apartments = Apartment::all();
        $apartment = Apartment::where('id', $slug)->first();

        if($apartment->imgs){
            $apartment->imgs = url('storage/' . $apartment->imgs);
        }

        return response()->json([
            'success' => true,
            'results' => $apartment
        ]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sponsor($id)
    {
        //
    }

    public function stats($id)
    {
        //
    }

    public function email($id)
    {
        //
    }

    public function searchApartments()
    {
        //
    }
}

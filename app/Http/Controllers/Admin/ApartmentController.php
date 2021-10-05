<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

// modelli importati

use App\Service;
use App\Apartment;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
            'desc' => 'required',
            'SelectedServices' => 'nullable',
            'r_rooms' => 'required',
            'n_beds' => 'required',
            'n_baths' => 'required',
            'square_meters' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
            'street' => 'required',
            'address' => 'required',
            'visible' => 'nullable',
        ]);
                
        // $id = Auth::user()->id;

        dd(Auth::id());

        // salvo la request
        $data = $request->all();

        // creare istanza del model Apartment
        $newApartment = new Apartment();

        /* cosi sarebbe l'inserimento  */
        /* $newApartment['user_id']=Auth::user()->id; */

        // creare lo slug a partire dal titolo
        $slug = Str::slug($data['title'],'-');

        // variabile probabilmente inutile
        // $slug_base = $slug;
        
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

        // salviamo lo slug univoco
        $newApartment->slug = $slug;

        $newApartment->fill($data);

        $newApartment->save();
        
        if(array_key_exists('services' ,$data)){
            $newApartment->services()->attach($data['SelectedServices']);
        }
        

        return redirect()->route('layouts.app');


        // chiamata api per lat - lon (TomTom)
        // inserire i dati nell'istanza
        // salvare i dati



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 
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
}

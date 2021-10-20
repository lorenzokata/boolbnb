<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Mail\SendNewMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

// import model
use App\Service;
use App\Apartment;
use App\Message;

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
            'user_id' => 'required',
            'square_meters' => 'required',
            'address' => 'required',
            
            'imgs' => 'nullable|image'
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
        if(array_key_exists('imgs',$data)){
            $imgs_path = Storage::put('imgs', $data['imgs']);

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
        
        if(array_key_exists('SelectedServices' ,$data)){
            $newApartment->services()->attach($data['SelectedServices']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $apartment = Apartment::where('slug', $slug)->with(['services'])->first();

        // da controllare
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
        
        // $apartments = Apartment::all();

        $apartment = Apartment::where('slug', $slug)->with(['services'])->first();
        $services = Service::all();

        if($apartment->imgs){
            $apartment->imgs = url('storage/' . $apartment->imgs);
        };

        return response()->json([
            'success' => true,
            'results' => [
                'apartment' => $apartment,
                'services' => $services,
            ]
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'n_rooms' => 'required',
            'n_beds' => 'required',
            'n_baths' => 'required',
            'slug' => 'required',
            'square_meters' => 'required',
            'address' => 'required',
            'visible' => 'nullable',
            'imgs' => 'nullable|image',
            'user_id' => 'required'

        ]);
        
        $data = $request->all();

        if($data['visible'] == 'on'){
            $data['visible'] = 1;
        }else{
            $data['visible'] = 0;
        }
        $apartment = Apartment::where('slug', $data['slug'])->first();

        if($data['user_id'] != $apartment->user_id){
            return false;
        };
        
        if($data['title'] != $apartment->title){

            $slug = Str::slug($data['title'],'-');
            
            //se lo slug è uguale ad uno già presente
            $slug_base = $slug; //titolo-di-esempio
            $slug_presente = Apartment::where('slug', $slug)->first();

            $contatore = 1;
            while($slug_presente){
                //aggiungiamo al post di prima -contatore
                $slug = $slug_base . '-' . $contatore; //titolo-di-esempio-1
                //controlliamo se il post esiste ancora
                $slug_presente = Apartment::where('slug', $slug)->first();
                //incrementiamo il contatore
                $contatore++;
            }

            //in ogni caso assegniamo allo slug il valore ottenuto
            $data['slug'] = $slug;
        };
        
        if(array_key_exists('imgs',$data)){
            //salviamo la nostra immagine e recuperiamo il path
            $cover_path = Storage::put('imgs', $data['imgs']);

            Storage::delete($apartment->imgs);
            //salviamo nella colonna della tabella posts l'immagine con il suo percorso
            $data['imgs'] = $cover_path;
        };

        $apartment->update($data);


        if(array_key_exists('SelectedServices', $data)){
            $apartment->services()->sync($data['SelectedServices']);
        }

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

    public function email(Request $request){

        $data = $request->all();
        // return $data;

        $validator = Validator::make($request->all(), [
            'sender_fullname' => 'required',
            'sender_email' => 'required|email',
            'msg' => 'required',
            'apartment_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
        
        $new_message = new Message();
        $new_message->fill($data);

        $new_message->save();

        return response()->json( ['success' => true] );

    }

    public function getEmails($id)
    {
        $messages = Message::where('apartment_id', $id)->get();
        $apartment = Apartment::where('id', $id)->first();
        
        return response()->json([
            'success' => true,
            'results' =>[
                'apartment' => $apartment,
                'messages' => $messages,
            ] 
        ]);
    }
}

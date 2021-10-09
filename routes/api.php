<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// qui vanno definite tutte le rotte API che possono essere chiamate dalle pages di Vue per prelevare i dati dal db

// Route::namespace('Admin')->group(function(){

//     Route::get('/apartment/create','ApartmentController@create');
//     Route::post('/apartment/store','ApartmentController@store');

//     // Route::post('/contacts', 'ContactController@store');
// });

// con autenticazione
Route::namespace('Api')->group(function () {
    
    Route::get('/home/{userInput}/{radius}', 'HomeController@home');
    Route::get('/dashboard', 'HomeController@dashboard');
    Route::get('/apartment/create', 'ApartmentController@create');
    Route::post('/apartment/store', 'ApartmentController@store');
    Route::get('/apartment/{slug}/edit', 'ApartmentController@edit');
    Route::post('/apartment/{slug}/update', 'ApartmentController@update');
    Route::post('/apartment/{slug}/delete', 'ApartmentController@destroy');
    Route::get('/apartment/{slug}/sponsor', 'ApartmentController@sponsor');
    Route::get('/apartment/{slug}/stats', 'ApartmentController@stats');
    Route::get('/apartment/{slug}', 'ApartmentController@show');
    Route::get('/apartment/{slug}/email', 'ApartmentController@email');
    Route::get('/apartment/search-results', 'ApartmentController@searchApartments');

});

// senza autenticazione

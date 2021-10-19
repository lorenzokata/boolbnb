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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// senza autenticazione
Route::namespace('Api')->group(function () {

    // caricamento della home Home.vue (mounted)
    Route::get('/home', 'HomeController@getTrending');

    // ricerca con filtri SearchResults.vue (mounted)
    Route::get('/search-results/{userInput}/{radius}/{nbeds}/{nrooms}/{filterS}', 'HomeController@home');

    // dettagli appartamento show.vue (mounted)
    Route::get('/apartment/show/{slug}', 'ApartmentController@show');

    // elenco appartamenti dell'host Dashboard.vue (mounted)
    Route::get('/dashboard/{userId}', 'HomeController@dashboard');

    // elenco servizi in Create.vue (mounted)
    Route::get('/apartment/create', 'ApartmentController@create');

    // salvataggio dati nuovo appartamento Create.vue
    Route::post('/apartment/store', 'ApartmentController@store');

    // caricamento dei dati dell'appartamento da modificare Edit.vue (mounted)
    Route::get('/apartment/{slug}/edit', 'ApartmentController@edit');

    // salvataggio dei dati modificati Edit.vue
    Route::post('/apartment/update', 'ApartmentController@update');

    
    Route::post('/apartment/{slug}/delete', 'ApartmentController@destroy');
    Route::get('/apartment/{slug}/sponsor', 'ApartmentController@sponsor');
    Route::get('/apartment/{slug}/stats', 'ApartmentController@stats');

    // caricamento dei dati delle e-mail dalla Show.vue
    Route::post('/apartment/email', 'ApartmentController@email');
    Route::get('/apartment/myEmails/{id}', 'ApartmentController@getEmails');

});
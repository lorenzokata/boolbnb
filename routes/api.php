<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// qui vanno definite tutte le rotte API che possono essere chiamate dalle pages di Vue per prelevare i dati dal db

Route::namespace('Admin')->group(function(){

    Route::get('/apartment/create','ApartmentController@create');
    Route::post('/apartment/store','ApartmentController@store');

    // Route::post('/contacts', 'ContactController@store');
});
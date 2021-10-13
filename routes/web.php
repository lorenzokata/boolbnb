<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

// con autenticazione
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', 'RouteController@view');
    Route::get('/apartment/create', 'RouteController@view');
    Route::get('/apartment{slug-app}/edit', 'RouteController@view');
    Route::get('/apartment/{slug-app}/update', 'RouteController@view');
    Route::get('/apartment/{slug-app}/delete', 'RouteController@view');
    Route::get('/apartment{slug-app}/sponsor', 'RouteController@view');
    Route::get('/apartment{slug-app}/stats', 'RouteController@view');
    
});

// senza autenticazione

Route::get('/', 'RouteController@view');
Route::get('/apartment/show', 'RouteController@view');
Route::get('/apartment{slug-app}/email', 'RouteController@view');
Route::get('/apartment/search-results', 'RouteController@view');
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->namespace('Admin')->prefix('admin')->name('admin.')->group(function() {
// pagina di atterraggio dopo il login (con il prefisso, l'url è '/admin')
    Route::get('/', 'ApartmentController@index')->name('index');
    Route::get('/{any?}', 'ApartmentController@index')->where('any', '.*');
});

Auth::routes();

// vue-router


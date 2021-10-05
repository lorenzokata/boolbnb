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

// middleware
Route::middleware('auth')->get('/apartment/create', function () { 
    
    return view('layouts.app');

});

Route::get('/{any?}', function () { 
    
    return view('layouts.app');
    
})->where("any", ".*");
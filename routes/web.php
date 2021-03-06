<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\gameController;
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

Route::get('/home', function () {
    // Retrieve a piece of data from the session...
    $value = session('key');

    // Specifying a default value...
    $value = session('key', 'default');

    // Store a piece of data in the session...
    session(['key' => 'value']);
});


Route::post('/game/create', 'App\Http\Controllers\GameController@createGame');

Route::get('/game', 'App\Http\Controllers\GameController@game');

Route::post('/game/guess', 'App\Http\Controllers\GameController@turn');

Route::get('/gameOver', 'App\Http\Controllers\GameController@gameOver');

Route::get('/gameWin', 'App\Http\Controllers\GameController@gameWin');

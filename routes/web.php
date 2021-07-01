<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index');
// creiamo rotta pubblica per i posts:
Route::get('/posts', 'PostController@index')->name('posts.index');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// creiamo le rotte admin
Route::prefix('admin')
// il prefix aggiunge la scritta al percorso in modo da non doverlo ripetere
->namespace('Admin')
// il namespace rappresenta la cartella all' interno dei controller e verrà inserito prima di HomeController
->middleware('auth')
// il middelware controlla se siamo loggati; in queste rotte, se non autenticato, l utente non potrà accedere
->name('admin.')
// con name diamo un prefisso al name della rotta
->group(function(){
    Route::get('/', 'HomeController@index')
    ->name('home');

    // creiamo rotta posts index per gli admin
    // Route::get('/posts', 'PostController@index');
    // se utilizziamo resource creiamo tutte le rotte della crud:
    Route::resource('/posts', 'PostController@index');
});

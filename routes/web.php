<?php

// use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// rotta per utenti non loggati:
Route::get('/', 'HomeController@index')->name("index");

// rotta posts per utenti non loggati
Route::get('/posts', 'PostController@index')->name("posts.index");

Route::get('/posts/{slug}', "PostController@show")->name("posts.show");

//ci crea tutte le rotte in auth, che gestiscono l' autenticazione
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
// con name diamo un prefisso al name della rotta per differenziarle da quelle pubbliche
->group(function(){
    Route::get('/', 'HomeController@index')->name('index');
    // inseriamo la rotta per i post degli admin con il resource che prenderà tutte le rotte della crud
    Route::resource('/posts', 'PostController');
    // inseriamo la rotta delle categorie
    Route::get('/categories', 'CategoryController@index')->name('categories.index');

});

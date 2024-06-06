<?php

use App\Http\Controllers\Api\AllergeniController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RistoratoreController;
use App\Http\Controllers\Api\PrenotazioniController;
use App\Http\Controllers\Api\IngredienteController;
use App\Http\Controllers\Api\PietanzaController;
use App\Http\Controllers\Api\InvitoController;
use App\Http\Middleware\UserIsClient;
use App\Http\Middleware\UserIsRestaurant;
use App\Http\Middleware\UserIsAuthenticated;
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

Route::middleware('auth:sanctum')->group(function () {

    // inserire qui dentro chiamate api per utente autenticato e solo utente autenticato

    Route::post('/user', [UserController::class, 'showUserInfo'])
        ->middleware('authenticated');

    Route::delete('/user', [UserController::class, 'deleteUser'])
        ->middleware('authenticated');

    Route::put('/useremail', [UserController::class, 'updateUserEmail'])
        ->middleware('authenticated');

    Route::put('/userpassword', [UserController::class, 'updateUserPassword'])
        ->middleware('authenticated');

    Route::get('/ristoratori/{id}', [RistoratoreController::class, 'listByUser']);
    Route::post('/crea-ristoratore', [RistoratoreController::class, 'store']);
    Route::get('/get-ristoratore/{id}', [RistoratoreController::class, 'show']);
    Route::put('/modifica-ristoratore/{id}', [RistoratoreController::class, 'update']);
    Route::delete('/elimina-ristoratore/{id}', [RistoratoreController::class, 'destroy']);

    Route::get('/prenotazioni', [PrenotazioniController::class, 'index']);
    Route::get('/prenotazioni/{id}', [PrenotazioniController::class,'show']);
    Route::post('/crea-prenotazione', [PrenotazioniController::class,'store']);
    Route::put('/prenotazioni/{id}', [PrenotazioniController::class,'update']);
    Route::delete('/prenotazioni/{id}', [PrenotazioniController::class,'destroy']);
    Route::put('/update-prenotazioni/{id}', [PrenotazioniController::class,'updateStatus']);
    Route::get('/dashboard_c/{id}',[PrenotazioniController::class,'dashboard_c']);
    Route::get('/prenotazione_c/{id}',[PrenotazioniController::class,'prenotazione_c']);

    Route::get('/ingredienti/{id}', [IngredienteController::class, 'index']);
    Route::put('/ingredienti/{id}', [IngredienteController::class,'update']);
    Route::delete('/ingredienti/{id}', [IngredienteController::class, 'destroy']);
    Route::post('/ingredienti', [IngredienteController::class, 'store']);

    Route::get('/pietanze/{id}', [PietanzaController::class, 'index']);
    Route::put('/pietanze/{id}', [PietanzaController::class,'update']);
    Route::delete('/pietanze/{id}', [PietanzaController::class, 'destroy']);
    Route::post('/pietanze', [PietanzaController::class, 'store']);

    Route::post('/crea-invito',  [InvitoController::class, 'store']);

    /*
    Route::middleware(UserIsRestaurant::class) {
        Route::prefix('restaurant')->group(function () {})
        // inserire qui dentro chiamate api per ristoratore e solo ristoratore

    };

    Route::middleware(UserIsClient::class) {
    Route::prefix('client')->group(function () {})
        // inserire qui dentro chiamate api per cliente e solo cliente

    };
    */

    // inserire qui le chiamate api comuni a tutti e tre i tipi di utenti (ad esempio logout)
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/profiles',[ProfileController::class, 'getAllProfiles'])
        ->middleware('authenticated');

    Route::post('/selectprofile',[ProfileController::class, 'selectProfile'])
        ->middleware('authenticated');
});

Route::get('/account',[ClientController::class,'index']);
Route::get('client/{id}', [ClientController::class,'show']);
Route::post('/client',[ClientController::class,'store']);
Route::put('/client',[ClientController::class,'update']);
Route::delete('client/{id}',[ClientController::class,'destroy']);

Route::get('/allergeni',[AllergeniController::class,'index']);

// inserire qui le chiamate per gli utenti non autenticati

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/ristoranti',[RistoratoreController::class,'index']);
Route::get('/ristorante/{id}',[RistoratoreController::class,'show']);
Route::get('/menu/{id}', [RistoratoreController::class, 'menu']);

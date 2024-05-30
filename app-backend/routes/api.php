<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RistoratoreController;
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

    // Da fare il middleware
    Route::get('/ristoratori/{id}', [RistoratoreController::class, 'listByUser']);
    Route::post('/crea-ristoratore', [RistoratoreController::class, 'store']);
    Route::get('/get-ristoratore/{id}', [RistoratoreController::class, 'show']);
    Route::put('/modifica-ristoratore/{id}', [RistoratoreController::class, 'update']);
    Route::delete('/elimina-ristoratore/{id}', [RistoratoreController::class, 'destroy']);
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

});


// inserire qui le chiamate per gli utenti non autenticati

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);


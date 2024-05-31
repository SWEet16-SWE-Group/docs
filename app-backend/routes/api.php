<?php

use App\Http\Controllers\AllergeniController;
use App\Http\Controllers\ClientController;
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

Route::get('/account',[ClientController::class,'index']);
Route::get('client/{id}', [ClientController::class,'show']);
Route::post('/client',[ClientController::class,'store']);
Route::put('/client',[ClientController::class,'update']);
Route::delete('client/{id}',[ClientController::class,'destroy']);

Route::get('/allergeni',[AllergeniController::class,'index']);
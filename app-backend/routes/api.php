<?php

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
Route::get('account/{id}', [ClientController::class,'show']);
Route::post('/account',[ClientController::class,'store']);
Route::put('/account',[ClientController::class,'update']);
Route::delete('account/{id}',[ClientController::class,'destroy']);
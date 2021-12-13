<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\VerifyTokenIsValid;
use App\Http\Controllers\PlayerController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource('v1/players', PlayerController::class)->middleware(VerifyTokenIsValid::class);
Route::get('v1/players', [PlayerController::class, 'getAllPlayers'])->middleware(VerifyTokenIsValid::class);
Route::get('v1/team', [PlayerController::class, 'GetPlayersByTeam'])->middleware(VerifyTokenIsValid::class);

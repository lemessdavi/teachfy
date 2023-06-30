<?php

use App\Http\Controllers\DeckController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [TokenController::class, 'gerarToken']);

Route::get('decks',  [DeckController::class, 'index']);

//deve estar dentro do middleware auth
Route::apiResource('decks', DeckController::class);
Route::apiResource('users', UserController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

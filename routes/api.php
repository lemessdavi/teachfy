<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AutomaticCardCreationController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'login']);

Route::get('decks', [DeckController::class, 'index']);

Route::post('users', [UserController::class, 'store']);
Route::put('users', [UserController::class, 'update']);
Route::get('users', [UserController::class, 'show']);

//autenticação
Route::group(['middleware' => ['auth.react']], function () {
    Route::apiResource('decks', DeckController::class);

    Route::get('/generate', [AutomaticCardCreationController::class, 'create']);
});

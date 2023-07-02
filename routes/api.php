<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AutomaticCardCreationController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'login']);

Route::get('/community', [CommunityController::class, 'index']);

Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::get('/users/{id}', [UserController::class, 'show']);

//autenticação
Route::group(['middleware' => ['auth.react']], function () {
    Route::apiResource('decks', DeckController::class);

    Route::get('/generate', [AutomaticCardCreationController::class, 'create']);
});

<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Participant;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/paticipants', function () {
   
    $participant = Participant::find(1);

    // foreach ($participant->users as $user) {
    //     echo $user->name . "<br>";
    // }

    return $participant->users->name;
});

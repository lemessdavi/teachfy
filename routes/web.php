<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\Participant;
use OpenAI as GlobalOpenAI;
use OpenAI\Laravel\Facades\OpenAI;

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


Route::get('/paticipants/{id}', function ($id) {
    $participant = Participant::find($id);

    return $participant->user->name;
});

Route::resource('users', UserController::class);

Route::get('/ask/{n}/{prompt}', function ($n, $prompt) {

    $result = OpenAI::completions()->create([
        'model' => 'text-davinci-003',
        'prompt' => 'O texto a seguir é um tema fornecido pelo usuário, formule '. $n .' pergunta sobre o tema '.  $prompt,
        'max_tokens' => 500,
    ]);
     
    echo $result['choices'][0]['text']; // an open-source, widely-used, server-side scripting language.
});
 

<?php

use App\Http\Controllers\AutomaticCardCreationController;
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

Route::get('/generate', [AutomaticCardCreationController::class, 'create']); 

Route::get('/ask/{n}/{prompt}', function ($n, $prompt) {

    if( 1 == 1){ //
        $options = ', toda questao deve ser objetiva, contendo 4 opcoes de resposta';
    };

    if( 1 == 1){ //
        $answer = ', por fim me indique também qual é a resposta correta para a pergunta';
    };

    $result = OpenAI::completions()->create([
        'model' => 'text-davinci-003',
        'prompt' => 'O texto a seguir é um tema fornecido pelo usuário, formule '. $n .' pergunta sobre o tema '.  $prompt.
        'retorne elas para mim em formato de JSON, separando cada pergunta, sempre chame cada uma delas de (pergunta + numero da pergunta)'. $options. $answer   ,
        'max_tokens' => 3500,
    ]);
     
    echo $result['choices'][0]['text']; // an open-source, widely-used, server-side scripting language.
});
 
//com gabarito junto
Route::get('/ask2/{n}/{prompt}', function ($n, $prompt) {

    $result = OpenAI::completions()->create([
        'model' => 'text-davinci-003',
        'prompt' => 'O texto a seguir é um tema fornecido pelo usuário, formule '. $n .' pergunta sobre o tema '.  $prompt.
        'retorne elas para mim em formato de JSON, separando cada pergunta, sempre chame cada uma delas de (pergunta + numero da pergunta)',
        'max_tokens' => 500,
    ]);
     
    echo $result['choices'][0]['text']; // an open-source, widely-used, server-side scripting language.
});

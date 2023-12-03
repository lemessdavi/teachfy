<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AutomaticCardCreationController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

Route::post('/login', [LoginController::class, 'login']);

Route::get('/community', [CommunityController::class, 'index']);

Route::post('/users', [UserController::class, 'store']);

Route::get('/allfromdeck/{id}', [DeckController::class, 'getAllFromDeck']);

//autenticação
Route::group(['middleware' => ['auth.react']], function () {
    Route::put('/users', [UserController::class, 'update']);
    Route::get('/users', [UserController::class, 'show']);
    Route::get('/users/{id}', [UserController::class, 'getOne']);
    Route::delete('/users/delete/{id}', [UserController::class, 'destroy']);
    Route::apiResource('decks', DeckController::class);
    Route::apiResource('cards', CardController::class);
    Route::apiResource('options', OptionController::class);

    Route::get('/cards/{id}/options', [OptionController::class, 'filteredOption']);

    Route::post('/cards', [CardController::class, 'store'] );

    Route::get('/generate', [AutomaticCardCreationController::class, 'create']);


    Route::get('/ask/{n}/{prompt}/{type}', function ($n, $prompt, $type) {

        $options = '';
        $answer = '';
        $json = '';

        if ($type == 1) { // Objetiva
            $options = ', toda questao deve ser objetiva, contendo 4 opcoes de resposta';
            $answer = ', por fim me indique também qual é a resposta correta para a pergunta';
            $json = 'Apresente o resultado em formato JSON conforme exemplo abaixo, SUA RESPOSTA DEVE SER SOMENTE UM JSON, NADA MAIS
            [{
            "question": teste,
            "answers": [
                {
                "description": "teste1",
                "isCorrect": 0
                },
                {
                "description": "teste2",
                "isCorrect": 1
                }
            ]
            }]';
        }

        if ($type == 2) { // Dissertativa and Anki
            $answer = ', por fim me indique também qual é a resposta correta para a pergunta';
            $json = 'Apresente o resultado em formato JSON conforme exemplo abaixo, SUA RESPOSTA DEVE SER SOMENTE UM JSON, NADA MAIS
            [{
            "question": teste,
            "answer": resposta teste
            }
            }]
            ';
        }

        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => 'O texto a seguir é um tema fornecido pelo usuário, formule ' . $n . ' pergunta sobre o tema ' . $prompt .
                $options . $answer . $json,
            'max_tokens' => 3500,
        ]);

        $response = [
            'data' => json_decode($result['choices'][0]['text'])
        ];

        return response()->json($response);
    });


    Route::post('/send-notification', function (Request $request) {
        $title = $request->input('title');
        $body = $request->input('body');
    
        $factory = (new Factory)->withServiceAccount('../firebase-config.json');
        $messaging = $factory->createMessaging();
    
        $notification = Notification::fromArray([
            'title' => $title,
            'body' => $body
        ]);
    
        $message = CloudMessage::withTarget('token', "cG7RuH8xR-mJSM94gcaaYe:APA91bEHgNkqL6RHWm_UrcYDI7VLCUcXmoXwftkCjFPJZY1uW6DS-X88ewI27Dgz-J8MyntcQRntG9oqvZZq_3AMJXkKr781t6I9biqKOUpGkcDo81v7GdDae4MzdLeQDClozOwPEbz8")
            ->withNotification($notification); // Adicione a notificação à mensagem
    
            try {
                $messaging->send($message);
            
                return response()->json(['success' => true, 'title' => $title, 'body' => $body]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'error' => $e->getMessage()]);
            }
    });
});

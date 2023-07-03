<?php

use Illuminate\Support\Facades\Route;
use OpenAI as GlobalOpenAI;
use OpenAI\Laravel\Facades\OpenAI;

Route::get('/ask/{n}/{prompt}/{type}', function ($n, $prompt, $type) {

  $options = '';

    if($type == 1 ){ //objetiva
        $options = ', toda questao deve ser objetiva, contendo 4 opcoes de resposta';
        $answer  =  ', por fim me indique também qual é a resposta correta para a pergunta';
        $json = 'Apresente o resultado em formato JSON conforme exemplo abaixo 
        {
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
          }';
    };

    if($type == 2){ //dissertativa and anki
        $answer = ', por fim me indique também qual é a resposta correta para a pergunta';
        $json = 'Apresente o resultado em formato JSON conforme exemplo abaixo 
        {
          "question": teste,
          "answer": resposta teste
        }';
    };

    $result = OpenAI::completions()->create([
        'model' => 'text-davinci-003',
        'prompt' => 'O texto a seguir é um tema fornecido pelo usuário, formule '. $n .' pergunta sobre o tema '.  $prompt.
        $options . $answer . $json ,
        'max_tokens' => 3500,
    ]);
     
    echo $result['choices'][0]['text']; // an open-source, widely-used, server-side scripting language.
});

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AutomaticCardCreationRequest;
use OpenAI;

class AutomaticCardCreationController extends Controller
{

    public function create(AutomaticCardCreationRequest $request)
    {
        if( $request->get('type') == 2){ //
            $options = ', toda questao deve ser objetiva, contendo 4 opcoes de resposta';
        };

        if( $request->get('answer') == 1){ //
            $answer = ', por fim me indique também qual é a resposta correta para a pergunta';
        };

        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => 'O texto a seguir é um tema fornecido pelo usuário, formule '. $request->get('n').' pergunta sobre o tema '.  $request->get('prompt').
            'retorne elas para mim em formato de JSON, separando cada pergunta, sempre chame cada uma delas de (pergunta + numero da pergunta)'.
             $options. $answer,
            'max_tokens' => 500,
        ]);

        return $result;
    }

}

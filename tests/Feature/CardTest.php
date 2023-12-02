<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CardTest extends TestCase
{
    /** @test */
    public function ValidarSeCardEhCriado(): void
    {
        $headers = [
            'accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRhdmlAZW1haWwuY29tIn0.NUVoztYgNzqEtp0fKN36cWaMih0itoDqfONPD06NdYE'
        ];

        $this->criarDeck($headers);

        $url = 'http://127.0.0.1:8000/api/cards';

        $card = [
            "deck_id" => 1,
            "deck_type" => 1,
            "type" => 3,
            "question" => "quanto é 2+2?",
            "answer" => "4",
            "points" => null
        ];

        $response = $this->post($url, $card, $headers);

        $response->assertStatus(201);
    }

    public function criarDeck($headers) {
        $url = 'http://127.0.0.1:8000/api/decks';

        $deck = [
            "user_id" => 1,
            "folder_id" => null,
            "name" => "teste2",
            "public" => 0,
            "clonable" => 0,
            "feedback" => 0,
            "type" => 1,
            "created_at" => "2023-10-26T13:45:33.000000Z",
            "updated_at" => "2023-10-26T13:45:33.000000Z",
            "description" => null
        ];

        $this->post($url, $deck, $headers);
    }
}

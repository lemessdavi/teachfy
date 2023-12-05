<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeckTDDTest extends TestCase
{
    /** @test */
    public function DeveRemoverDeckExistente(): void
    {
        $headers = [
            'accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRhdmlAZW1haWwuY29tIn0.NUVoztYgNzqEtp0fKN36cWaMih0itoDqfONPD06NdYE'
        ];

        $this->criarUsuario();
        $this->criarDeck($headers);

        $url = 'http://127.0.0.1:8000/api/decks/1';

        $response = $this->delete($url, [], $headers);

        $response->assertStatus(200);
    }

    /** @test */
    public function DeveFalharAoRemoverDeckInexistente(): void
    {
        $headers = [
            'accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRhdmlAZW1haWwuY29tIn0.NUVoztYgNzqEtp0fKN36cWaMih0itoDqfONPD06NdYE'
        ];

        $url = 'http://127.0.0.1:8000/api/decks/-1';

        $response = $this->delete($url, [], $headers);

        $response->assertStatus(404);
    }

    /** @test */
    public function DeveRecuperarCardsDeUmDeckExistente(): void
    {
        $headers = [
            'accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRhdmlAZW1haWwuY29tIn0.NUVoztYgNzqEtp0fKN36cWaMih0itoDqfONPD06NdYE'
        ];

        $this->criarDeck($headers);

        $url = 'http://127.0.0.1:8000/api/allfromdeck/2';

        $response = $this->get($url, [], $headers);

        $response->assertStatus(200);
    }

    /** @test */
    public function DeveFalharAoRecuperarCardsDeUmDeckInexistente(): void
    {
        $headers = [
            'accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRhdmlAZW1haWwuY29tIn0.NUVoztYgNzqEtp0fKN36cWaMih0itoDqfONPD06NdYE'
        ];

        $this->criarDeck($headers);

        $url = 'http://127.0.0.1:8000/api/allfromdeck/-1';

        $response = $this->get($url, $headers);

        $response->assertStatus(404);
    }

    public function criarDeck($headers)
    {
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

    /** @test */
    public function DeveRecuperarDecksDeUmUsuarioExistente(): void
    {
        $headers = [
            'accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRhdmlAZW1haWwuY29tIn0.NUVoztYgNzqEtp0fKN36cWaMih0itoDqfONPD06NdYE'
        ];

        $this->criarDeck($headers);

        $url = 'http://127.0.0.1:8000/api/decks';

        $response = $this->get($url, $headers);

        $response->assertStatus(200);
    }

    /** @test */
    public function DeveRecuperarDecksDeUmUsuarioInexistente(): void
    {
        $headers = [
            'accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRhdmlAZW1haWwuY29tIn0.NUVoztYgNzqEtp0fKN36cWaMih0itoDqfONPD06NdYE'
        ];

        $this->criarDeck($headers);

        $url = 'http://127.0.0.1:8000/api/decks/-1';

        $response = $this->get($url, $headers);

        $response->assertStatus(404);
    }

    public function criarUsuario()
    {
        $url = 'http://127.0.0.1:8000/api/users';

        $user = [
            'name' => 'caue',
            'email' => 'davi@email.com',
            'password' => 'teste1234',
            'password_confirmation' => 'teste1234'
        ];

        $this->post($url, $user);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTDDTest extends TestCase
{
    /** @test */
    public function DeveRemoverUsuarioExistente(): void
    {
        $this->criarUsuario();

        $headers = [
            'accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRhdmlAZW1haWwuY29tIn0.NUVoztYgNzqEtp0fKN36cWaMih0itoDqfONPD06NdYE'
        ];

        $urlDelete = 'http://127.0.0.1:8000/api/users/delete/2';

        $response = $this->delete($urlDelete, [], $headers);

        $response->assertStatus(200);
    }

    /** @test */
    public function DeveFalharAoRemoverUsuarioInexistente(): void
    {
        $this->withoutExceptionHandling();

        $headers = [
            'accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRhdmlAZW1haWwuY29tIn0.NUVoztYgNzqEtp0fKN36cWaMih0itoDqfONPD06NdYE'
        ];

        $urlDelete = 'http://127.0.0.1:8000/api/users/delete/-1';

        $response = $this->delete($urlDelete, [], $headers);

        $response->assertStatus(404);
    }

    /** @test */
    public function DeveRecuperarInformacoesDeUsuarioExistente(): void
    {
        $headers = [
            'accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRhdmlAZW1haWwuY29tIn0.NUVoztYgNzqEtp0fKN36cWaMih0itoDqfONPD06NdYE'
        ];

        $url = 'http://127.0.0.1:8000/api/users/1';

        $response = $this->get($url, $headers);

        $response->assertStatus(200);
    }

    /** @test */
    public function DeveRecuperarInformacoesDeUsuarioInexistente(): void
    {
        $headers = [
            'accept' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRhdmlAZW1haWwuY29tIn0.NUVoztYgNzqEtp0fKN36cWaMih0itoDqfONPD06NdYE'
        ];

        $url = 'http://127.0.0.1:8000/api/users/-1';

        $response = $this->get($url, $headers);

        $response->assertStatus(404);
    }

    public function criarUsuario()
    {
        $url = 'http://127.0.0.1:8000/api/users';

        $user = [
            'name' => 'cauemarques',
            'email' => 'cauemarques@gmail.com',
            'password' => 'caue1234',
            'password_confirmation' => 'caue1234'
        ];

        $this->post($url, $user);
    }
}

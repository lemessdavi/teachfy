<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function validaSeUsuarioEhCriado(): void
    {

        $url = 'http://127.0.0.1:8000/api/users';

        $user = [
            'name' => 'cauemarques',
            'email' => 'caue@gmail.com',
            'password' => 'caue1234',
            'password_confirmation' => 'caue1234'
        ];

        $response = $this->post($url, $user);

        $response->assertStatus(201);

        $this->artisan('migrate:fresh');
    }

    /** @test */
    public function validaSeUsuarioComNomeInvalidoNaoEhSalvo(): void
    {

        $url = 'http://127.0.0.1:8000/api/users';

        $user = [
            'name' => '',
            'email' => 'caue@gmail.com',
            'password' => 'caue1234',
            'password_confirmation' => 'caue1234'
        ];

        $headers = ['accept' => 'application/json'];

        $response = $this->post($url, $user, $headers);

        $response->assertStatus(422);

        $this->artisan('migrate:fresh');
    }

    /** @test */
    public function validaSeUsuarioComEmailInvalidoNaoEhSalvo(): void
    {

        $url = 'http://127.0.0.1:8000/api/users';

        $user = [
            'name' => 'caue',
            'email' => 'caue@asdada',
            'password' => 'caue1234',
            'password_confirmation' => 'caue1234'
        ];

        $headers = ['accept' => 'application/json'];

        $response = $this->post($url, $user, $headers);

        $response->assertStatus(422);

        $this->artisan('migrate:fresh');
    }

    /** @test */
    public function validaSeUsuarioComEmailJaExistenteNaoEhSalvo(): void
    {
        $this->withoutExceptionHandling();

        $url = 'http://127.0.0.1:8000/api/users';

        $user = [
            'name' => 'cauemarques',
            'email' => 'caue@gmail.com',
            'password' => 'caue1234',
            'password_confirmation' => 'caue1234'
        ];

        $this->post($url, $user);

        $user2 = [
            'name' => 'caue',
            'email' => 'caue@gmail.com',
            'password' => 'teste1234',
            'password_confirmation' => 'teste1234'
        ];

        $headers = ['accept' => 'application/json'];

        try {
            $this->post($url, $user2, $headers);
        } catch (\Throwable $e) {
        }
        $this->assertEquals(
            new HttpException(400, 'Dados inválidos'), $e
        );

        $this->artisan('migrate:fresh');
    }

    /** @test */
    public function validaSeUsuarioComSenhaInvalidaNaoEhSalvo(): void
    {

        $url = 'http://127.0.0.1:8000/api/users';

        $user = [
            'name' => 'caue',
            'email' => 'caue@gmail.com',
            'password' => 'novoteste',
            'password_confirmation' => 'novoteste'
        ];

        $headers = ['accept' => 'application/json'];

        $response = $this->post($url, $user, $headers);

        $response->assertStatus(422);

        $this->artisan('migrate:fresh');
    }

    /** @test */
    public function validaSeUsuarioComSenhaEConfirmacaoDeSenhaDiferentesNaoEhSalvo(): void
    {

        $url = 'http://127.0.0.1:8000/api/users';

        $user = [
            'name' => 'caue',
            'email' => 'caue@gmail.com',
            'password' => 'novoteste',
            'password_confirmation' => 'novoteste2'
        ];

        $headers = ['accept' => 'application/json'];

        $response = $this->post($url, $user, $headers);

        $response->assertStatus(422);

        $this->artisan('migrate:fresh');
    }
}

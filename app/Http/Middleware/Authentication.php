<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\{JWT, Key, SignatureInvalidException};

class Authentication {

    public function handle(Request $request, Closure $next): mixed {
        try {
            if (!$request->hasHeader('Authorization')) {
                throw new Exception('Cabeçalho "Authorization" não encontrado');
            }

            $token = $this->replaceToken($request->header('Authorization'));

            $dadosAutenticacao = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            $user = User::query()->where('email', $dadosAutenticacao->email)->first();

            if (is_null($user)) {
                throw new Exception('Token inválido.');
            }

            Auth::login($user);
            return $next($request);

        } catch (SignatureInvalidException $e) {
            throw new Exception('Token inválido.');
        }
    }

    private function replaceToken(string $token): string {
        return str_replace('Bearer ', '', $token);
    }

}

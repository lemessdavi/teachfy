<?php

namespace App\Services;

use App\Models\User;
use Firebase\JWT\JWT;

class TokenService {

    public static function generateToken(array $dados): string {
        return JWT::encode($dados, env('JWT_SECRET'), 'HS256');
    }

    public static function generateUserToken(User $user): string {
        return self::generateToken(['email' => $user->email]);
    }
}

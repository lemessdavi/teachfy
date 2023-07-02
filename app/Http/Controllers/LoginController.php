<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\TokenService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller {

    public function login(LoginRequest $request): JsonResponse|array {
        try {
            $user = User::query()->where('email', $request->email)->first();

            if (is_null($user) || !Hash::check($request->password, $user->password)) {
                throw new Exception('E-mail ou senha inválidos.');
            }

            $token = TokenService::generateUserToken($user);
            return response()->json(['message' => 'Login efetuado com sucesso', 'data' => ['token' => $token]]);
        } catch (Exception $e) {
            throw new Exception('E-mail ou senha inválidos. ' . $e->getMessage());
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\TokenService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(['message' => 'Todos os users:', 'data' => User::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): JsonResponse
    {
        //
        try {
            DB::beginTransaction();
            $user = new User();
            $user->fill($request->all());
            $user->password = Hash::make($request->password);
            $user->save();
            $user->token = TokenService::generateUserToken($user);

            DB::commit();
            return response()->json(['message' => 'Registro salvo com sucesso', 'data' => $user], 201);
        } catch (Exception $e) {
            DB::rollBack();
            abort(400, "Dados inválidos");
        }


        //return redirect to login?
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            $user = User::findOrFail(Auth::user()->id);

            return response()->json(['message' => 'Registro:', 'data' => $user]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): JsonResponse
    {
        //
        try {
            DB::beginTransaction();

            $user = User::findOrFail(Auth::user()->id);
            $user->fill($request->all());
            $user->password = Hash::make($request->password);
            $user->save();

            DB::commit();
            return response()->json(['message' => 'Registro alterado com sucesso', 'data' => $user]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user= User::FindOrFail($id);
            $user->delete();
            return response()->json(['user'=> $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message'=>'user not found!'], 404);
        }
    }

    public function getOne($id) {
        try {
            $user= User::FindOrFail($id);
            return response()->json(['user'=> $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message'=>'user not found!'], 404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $user->save();    

            DB::commit();
            return response()->json(['message' => 'Registro salvo com sucesso', 'data' => $user]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }


        //return redirect to login?
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try {
            $user = User::findOrFail($id);

            return response()->json(['message' => 'Registro:', 'data' => $user]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        //
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $user->fill($request->all());
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
    public function destroy(string $id)
    {
        //
    }
}

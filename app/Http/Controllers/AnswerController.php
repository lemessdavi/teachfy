<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerStoreRequest;
use App\Models\Answer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    public function store(AnswerStoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $answer = new Answer();
            $answer->fill($request->all());
            $answer->save();

            DB::commit();
            return response()->json(['message' => 'Registro salvo com sucesso', 'data' => $answer]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());//deverá haver tratamento de exception
        }
    }

    public function show(string $id)
    {
        //
        try {
            $answer = Answer::findOrFail($id);

            return response()->json(['message' => 'Registro: ', 'data' => $answer]);
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

            $answer = Answer::findOrFail($id);
            $answer->fill($request->all());
            $answer->save();    

            DB::commit();
            return response()->json(['message' => 'Registro alterado com sucesso', 'data' => $answer]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}

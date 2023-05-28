<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardStoreRequest;
use App\Models\Card;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function store(CardStoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $card = new Card();
            $card->fill($request->all());
            $card->save();

            DB::commit();
            return response()->json(['message' => 'Registro salvo com sucesso', 'data' => $card]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());//deverá haver tratamento de exception
        }
    }

    public function show(string $id)
    {
        //
        try {
            $card = Card::findOrFail($id);

            return response()->json(['message' => 'Registro: ', 'data' => $card]);
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

            $card = Card::findOrFail($id);
            $card->fill($request->all());
            $card->save();    

            DB::commit();
            return response()->json(['message' => 'Registro alterado com sucesso', 'data' => $card]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}

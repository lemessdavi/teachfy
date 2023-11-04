<?php

namespace App\Http\Controllers;

use App\Http\Requests\OptionStoreRequest;
use App\Models\Card;
use App\Models\Option;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptionController extends Controller
{
    public function store(OptionStoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $option = new Option();
            $option->fill($request->all());
            $option->save();

            DB::commit();
            return response()->json(['message' => 'Registro salvo com sucesso', 'data' => $option]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());//deverá haver tratamento de exception
        }
    }

    public function show(string $id)
    {
        //
        try {
            $option = Option::findOrFail($id);

            return response()->json(['message' => 'Registro: ', 'data' => $option]);
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

            $option = Option::findOrFail($id);
            $option->fill($request->all());
            $option->save();

            DB::commit();
            return response()->json(['message' => 'Registro alterado com sucesso', 'data' => $option]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }


    public function filteredOption(int $cardId)
    {
        try {
            DB::beginTransaction();

            $card = Card::findOrFail($cardId);
            $options = $card->options;

            DB::commit();
            return response()->json(['message' => 'Options carregadas com sucesso', 'data' => $options]);
        }catch (Exception ){
            DB::rollBack();
        }
    }
}

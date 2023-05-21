<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeckStoreRequest;
use App\Models\Deck;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DeckController extends Controller {

    public function store(DeckStoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // $deck = Deck::create($request->all());
            $deck = new Deck();
            $deck->fill($request->all());
            $deck->save();

            DB::commit();
            return response()->json(['message' => 'Registro salvo com sucesso', 'data' => $deck]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());//deverá haver tratamento de exception
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardStoreRequest;
use App\Models\Card;
use App\Models\Deck;
use App\Services\DeckFilterService;
use App\Services\PaginationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{

    public function index(Request $request)
    {
        $query = Card::query()->where('deck_id', $request->get('deck_id'));

//        $filters = $request->get('filters', false);
//        if ($filters && is_array($filters)) {
//            CardFilterService::addFilters($query, $filters);
//        }

        PaginationService::setCurrentPage($request->get('current_page', 1));

        $data = $query->simplePaginate($request->get('per_page', 10));

        return response()->json(['message' => 'Cards listados com sucesso.', 'data' => $data]);
    }
    public function store(CardStoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $card = new Card();
            $card->fill($request->all());
            $card->save();

            DB::commit();
            return response()->json(['message' => 'Registro salvo com sucesso', 'data' => $card], 201);
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

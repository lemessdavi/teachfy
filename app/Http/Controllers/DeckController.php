<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeckStoreRequest;
use App\Models\Card;
use App\Models\Deck;
use App\Services\DeckFilterService;
use App\Services\PaginationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeckController extends Controller {

    public function index(Request $request)
    {
        $query = Deck::query()->where('user_id', Auth::user()->id);

        $filters = $request->get('filters', false);
        if ($filters && is_array($filters)) {
            DeckFilterService::addFilters($query, $filters);
        }

        PaginationService::setCurrentPage($request->get('current_page', 1));

        $data = $query->simplePaginate($request->get('per_page', 10));

        return response()->json(['message' => 'Decks listados com sucesso.', 'data' => $data]);
    }

    public function store(DeckStoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $deck = new Deck();
            $deck->fill($request->all());
            $deck->user_id = Auth::user()->id;
            $deck->save();

            if ($request->get('cards', false) && is_array($request->get('cards'))) {
                foreach ($request->get('cards') as $card) {
                    $newCard = new Card();
                    $newCard->fill($card);
                    $newCard->deck_id = $deck->id;
                    $newCard->deck_type = $deck->type;
                    $newCard->save();
                }
            }

            DB::commit();
            return response()->json(['message' => 'Registro salvo com sucesso', 'data' => $deck]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());//deverá haver tratamento de exception
        }
    }

    public function show(string $id)
    {
        //
        try {
            $deck = Deck::findOrFail($id);
            $deck->cards;

            return response()->json(['message' => 'Registro: ', 'data' => $deck]);
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

            $deck = Deck::findOrFail($id);
            $deck->fill($request->all());
            $deck->save();

            DB::commit();
            return response()->json(['message' => 'Registro alterado com sucesso', 'data' => $deck]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function getAllFromDeck(string $id) {
        try {
            DB::beginTransaction();

            $query = Deck::with('cards')->with('options')->where('id', $id)->get();

            DB::commit();
            return response()->json(['message' => 'Registro alterado com sucesso', 'data' => $query]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function destroy($id) {
        try {
            $deck = Deck::FindOrFail($id);
            $deck->delete();
            return response()->json(['deck'=> $deck], 200);
        } catch (\Exception $e) {
            return response()->json(['message'=>'deck not found!'], 404);
        }
    }
}

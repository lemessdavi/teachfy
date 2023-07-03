<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use App\Services\DeckFilterService;
use App\Services\PaginationService;
use App\Structural\Enums\YesNo;
use Illuminate\Http\Request;

class CommunityController extends Controller {

    public function index(Request $request)
    {
        $query = Deck::query()->where('public', YesNo::YES->value);

        $filters = $request->get('filters', false);
        if ($filters && is_array($filters)) {
            DeckFilterService::addFilters($query, $filters);
        }

        PaginationService::setCurrentPage($request->get('current_page', 1));

        $data = $query->simplePaginate($request->get('per_page', 10));

        return response()->json(['message' => 'Decks listados com sucesso.', 'data' => $data]);
    }

}

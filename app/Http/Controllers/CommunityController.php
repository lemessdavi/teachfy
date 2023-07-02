<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use App\Structural\Enums\YesNo;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class CommunityController extends Controller {

    public function index(Request $request)
    {
        $query = Deck::query()->where('public', YesNo::YES->value);

        $filters = $request->get('filters', false);
        if ($filters && is_array($filters)) {
            if (in_array('type', $filters)) {
                $query->where('type', $filters['type']);
            }
            if (in_array('text', $filters)) {
                $value = '%' . str_replace(' ', '%', $filters['text']) . '%';

                $query->where(function($query) use ($value) {
                    $query->orWhere('name', 'ilike', $value)
                    ->orWhere('description', 'ilike', $value);
                });
            }
        }
        $perPage = $request->get('per_page', 10);
        $currentPage = $request->get('current_page', 1);

        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $data = $query->simplePaginate($perPage);

        return response()->json(['message' => 'Decks listados com sucesso.', 'data' => $data]);
    }

}

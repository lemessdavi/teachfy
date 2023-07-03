<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class DeckFilterService {

    public static function addFilters(Builder &$query, array $filters): void {
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

}

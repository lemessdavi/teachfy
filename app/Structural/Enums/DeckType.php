<?php

namespace App\Structural\Enums;

enum DeckType: int {

    case ANKI       = 1;
    case AVALIATIVO = 2;

    public function label(): string
    {
        return match ($this) {
            self::ANKI => 'Anki',
            self::AVALIATIVO => 'Avaliativo',
            default => 'Label não cadastrada'
        };
    }
}

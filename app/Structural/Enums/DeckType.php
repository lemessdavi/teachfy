<?php

namespace App\Structural\Enums;

enum DeckType: int {

    case AVALIATIVO = 1;
    case ANKI       = 2;

    public function label(): string
    {
        return match ($this) {
            self::AVALIATIVO => 'Avaliativo',
            self::ANKI => 'Anki',
            default => 'Label não cadastrada'
        };
    }
}

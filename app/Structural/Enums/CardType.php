<?php

namespace App\Structural\Enums;

enum CardType: int {

    case OBJETIVA = 1;
    case DISSERTATIVA = 2;

    public function label(): string
    {
        return match ($this) {
            self::OBJETIVA => 'Objetiva',
            self::DISSERTATIVA => 'Dissertativa',
            default => 'Label não cadastrada'
        };
    }
}

<?php

namespace App\Structural\Enums;

enum YesNo: int {

    case NO  = 0;
    case YES = 1;

    public function label(): string
    {
        return match ($this) {
            self::YES => 'Sim',
            self::NO  => 'Não',
            default => 'Label não cadastrada'
        };
    }
}

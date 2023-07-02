<?php

namespace App\Structural\Enums;

enum ParticipantPermission: int {

    case PROPRIETARIO = 1;
    case PARTICIPANTE = 2;

    public function label(): string
    {
        return match ($this) {
            self::PROPRIETARIO => 'Proprietário',
            self::PARTICIPANTE => 'Participante',
            default => 'Label não cadastrada'
        };
    }
}

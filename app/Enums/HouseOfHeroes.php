<?php

namespace App\Enums;

enum HouseOfHeroes: string
{
    case Makabayan = 'makabayan';
    case Makakalikasan = 'makakalikasan';
    case Makatao = 'makatao';
    case Makadiyos = 'makadiyos';

    public function label(): string
    {
        return match ($this) {
            self::Makabayan => 'Makabayan',
            self::Makakalikasan => 'Makakalikasan',
            self::Makatao => 'Makatao',
            self::Makadiyos => 'Makadiyos',
        };
    }
}

<?php

namespace App\Enums;

enum PermitEnum: string
{
    case no = 'no';
    case tescil = 'tescil';
    case muafiyet = 'muafiyet';
    case mudur = 'mudur';

    //case okul = 'okul';

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public function title(): string
    {
        return self::titles()[$this->value] ?? '-';
    }

    public static function titles(): array
    {
        return [
            self::no->value => 'Tüm Yetkiler',
            self::tescil->value => 'Tescil',
            self::muafiyet->value => 'Muafiyet',
            self::mudur->value => 'Müdür Müşteşarı',
            //self::okul->value => 'Okul',
        ];
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }
}

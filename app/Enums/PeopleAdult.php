<?php

namespace App\Enums;

enum PeopleAdult: string
{
    case noAdult = '0';
    case adult18 = '1';
    case under18 = '2';

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
            self::noAdult->value => __('peoples.noAdult'),
            self::adult18->value => __('peoples.adult18'),
            self::under18->value => __('peoples.under18'),
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

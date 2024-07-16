<?php

namespace App\Enums;

enum Gender: string
{
    case male = 'male';

    case female = 'female';

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function titles(): array
    {
        return [
            self::male->value => __('table.male'),
            self::female->value => __('table.female')
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

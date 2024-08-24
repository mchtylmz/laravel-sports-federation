<?php

namespace App\Enums;

enum Status: string
{
    case active = 'active';

    case passive = 'passive';

    case pending = 'pending';

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
            self::active->value => __('table.active'),
            self::passive->value => __('table.passive'),
            self::pending->value => __('table.pending'),
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

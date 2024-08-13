<?php

namespace App\Enums;

enum EventTypeEnum: string
{
    case event = 'event';
    case federation_date = 'federation_date';

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
            self::event->value => 'event',
            self::federation_date->value => 'federation_date'
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

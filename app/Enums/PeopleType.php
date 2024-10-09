<?php

namespace App\Enums;

enum PeopleType: string
{
    case player = 'player';
    case referee = 'referee';
    case coach = 'coach';
    case racer = 'racer';

    case school = 'school';
    case ferdi = 'ferdi';

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
            self::player->value => __('peoples.player'),
            self::referee->value => __('peoples.referee'),
            self::coach->value => __('peoples.coach'),
            self::racer->value => __('peoples.racer'),
            self::school->value => __('peoples.school'),
            self::ferdi->value => __('Ferdi Sporcu'),
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

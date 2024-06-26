<?php

namespace App\Enums;

enum UserType: string
{
    case superadmin = 'superadmin';

    case admin = 'admin';

    case manager = 'manager';

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function titles(): array
    {
        return [
            self::manager->value => __('users.manager'),
            self::admin->value => __('users.admin'),
            self::superadmin->value => __('users.superadmin'),
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

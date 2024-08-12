<?php

use \Illuminate\Support\Facades\DB;

if (!function_exists('role')) {
    function hasRole(...$roles): bool
    {
        foreach ($roles as $role) {
            if (in_array(auth()?->user()?->role, is_array($role) ? $role : [$role])) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('role')) {
    function role()
    {
        return auth()?->user()?->role;
    }
}

if (!function_exists('permit')) {
    function permit(string $name = ''): bool
    {
        if (auth()?->user()?->permit == 'no' || !hasRole('superadmin')) {
            return true;
        }

        return auth()?->user()?->permit == $name;
    }
}

if (!function_exists('user')) {
    function user()
    {
        return auth()?->user();
    }
}

if (!function_exists('federations')) {
    function federations()
    {
        return \App\Models\Federation::all();
    }
}

if (!function_exists('clubs')) {
    function clubs()
    {
        return \App\Models\Club::where('status', 'active')->get();
    }
}

if (!function_exists('peoples')) {
    function peoples()
    {
        return \App\Models\People::where('status', 'active')->get();
    }
}

if (!function_exists('permitCases')) {
    function permitCases()
    {
        return \App\Enums\PermitEnum::cases();
    }
}

if (!function_exists('users')) {
    function users()
    {
        return \App\Models\User::where('status', 'active')->get();
    }
}

if (!function_exists('eventStatuses')) {
    function eventStatuses(): array
    {
        return [
            'Henüz tamamlanmadı',
            'Tamamlandı',
            'İptal Edildi',
            'Ertelendi'
        ];
    }
}

if (!function_exists('eventPlaces')) {
    function eventPlaces(): array
    {
        return [
            ...places(),
            ...\App\Models\Event::distinct('location')->pluck('location')->toArray()
        ];
    }
}


if (!function_exists('authLog')) {
    function authLog(string $type): void
    {
        DB::table('logs')->insert([
            'user_id'    => auth()->id(),
            'log_date'   => now(),
            'table_name' => '',
            'log_type'   => $type,
            'ip'         => request()->ip(),
            'data_id'    => auth()->id(),
            'data'       => json_encode([
                'user_agent' => request()->userAgent()
            ])
        ]);
    }
}


if (!function_exists('customLog')) {
    function customLog(string $table_name, array $data = [], int $data_id = 0): void
    {
        DB::table('logs')->insert([
            'user_id'    => auth()->id(),
            'log_date'   => now(),
            'table_name' => $table_name,
            'log_type'   => 'edit',
            'ip'         => request()->ip(),
            'data_id'    => $data_id,
            'data'       => json_encode($data)
        ]);
    }
}

if (!function_exists('federation_clubs')) {
    function federation_clubs(int|null $federation_id)
    {
        $federation_id = intval($federation_id);
        return \App\Models\Club::whereRaw(
            sprintf("FIND_IN_SET('%d', federation_id)", $federation_id)
        )->get();
    }
}

if (!function_exists('places')) {
    function places()
    {
        return cache()->remember('places_all', 86400 * 30, function () {
            $places = [];

            $metas = DB::table('meta')
                ->where('key', 'places')
                ->pluck('value')
                ->map(function ($value) {
                    return json_decode($value, true) ?? [];
                })
                ->toArray();

            foreach ($metas as $value) {
                $places = array_merge($places, $value);
            }

            $places = array_unique($places);
            asort($places);

            return array_values($places);
        });
    }
}

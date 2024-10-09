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

if (!function_exists('permitIf')) {
    function permitIf(string $role, array $names): bool
    {
        if (in_array($role, ['admin', 'manager', 'calendar'])) {
            return true;
        }

        if (user()?->permit?->name == 'no') {
            return true;
        }

        return userPermit($names);
    }
}

if (!function_exists('userPermit')) {
    function userPermit(array $names): bool
    {
        if (in_array(user()?->permit?->name, $names)) {
            return true;
        }

        return false;
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
        if (hasRole('admin')) {
            return \App\Models\Federation::where('id', user()->federation()?->id)->orderBy('name', 'ASC')->get();
        }

        return \App\Models\Federation::orderBy('name', 'ASC')->get();
    }
}

if (!function_exists('clubs')) {
    function clubs()
    {
        if (hasRole('admin')) {
            return \App\Models\Club::where('status', 'active')
                ->whereRaw(sprintf("FIND_IN_SET('%s', federation_id) > 0", user()->federation()?->id))
                ->get();
        }

        return \App\Models\Club::where('status', 'active')->get();
    }
}

if (!function_exists('peoples')) {
    function peoples()
    {
        if (hasRole('admin')) {
            return \App\Models\People::where('status', 'active')
                ->where('federation_id', user()->federation()?->id)
                ->get();
        }

        return \App\Models\People::where('status', 'active')->get();
    }
}

if (!function_exists('permitCases')) {
    function permitCases()
    {
        return \App\Enums\PermitEnum::cases();
    }
}

if (!function_exists('eventTypeCases')) {
    function eventTypeCases()
    {
        return \App\Enums\EventTypeEnum::cases();
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
            'Yeni Etkinlik',
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
            'user_id'    => auth()->check() ? auth()->id() : $data_id,
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
    function federation_clubs(int|null $federation_id, array $select = [])
    {
        $federation_id = intval($federation_id);

        $clubs = \App\Models\Club::whereRaw(
            sprintf("FIND_IN_SET('%d', federation_id)", $federation_id)
        );
        if (!empty($select) && is_array($select) && !in_array('*', $select)) {
            $clubs->select($select);
        }
        if (hasRole('admin')) {

        }$clubs->where('selected', 1);

        return $clubs->get();
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

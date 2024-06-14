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

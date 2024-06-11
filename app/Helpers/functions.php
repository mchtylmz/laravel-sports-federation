<?php


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

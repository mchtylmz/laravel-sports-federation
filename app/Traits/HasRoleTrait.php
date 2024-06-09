<?php

namespace App\Traits;

trait HasRoleTrait
{
    public function hasRole(...$roles): bool
    {
        if (in_array($this?->role, $roles)) {
            return true;
        }
        return false;
    }

    public function role()
    {
        return $this->role;
    }
}

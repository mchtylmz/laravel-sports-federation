<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Configuration\Middleware;

class AppMiddleware
{
    public function __invoke(Middleware $middleware): void
    {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class
        ]);
    }
}

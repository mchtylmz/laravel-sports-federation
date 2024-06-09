<?php

namespace App\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Throwable;

class AppException
{
    public function __invoke(Exceptions $exceptions): void
    {

        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is('admin/*')) {
                return true;
            }

            return $request->expectsJson();
        });

    }
}

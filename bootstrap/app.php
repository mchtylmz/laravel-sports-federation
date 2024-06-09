<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        //commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(new \App\Http\Middleware\AppMiddleware())
    ->withExceptions(new \App\Exceptions\AppException())
    ->create();

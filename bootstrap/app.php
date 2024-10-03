<?php

use App\Http\Middleware\LogoutOnBack;
use App\Http\Middleware\NoCache;
use \App\Http\Middleware\Usertype;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        api: __DIR__ . '/../routes/api.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            "usertype" => Usertype::class,
            "logoutOnBack" => LogoutOnBack::class,
            "noCache" => NoCache::class,
            "api" => [
                \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
                'throttle:api',
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ],
        ]);
        /* $middleware->append([NoCache::class, LogoutOnBack::class]); */
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

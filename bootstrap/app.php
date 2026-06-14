<?php

use App\Http\Middleware\EnsureNotFrozen;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'notFrozen' => EnsureNotFrozen::class,
        ]);
        $middleware->appendToGroup('web', EnsureNotFrozen::class);

        // Render (and most PaaS) terminates TLS at the edge and forwards plain
        // HTTP to the container, with X-Forwarded-* headers. Trust them so
        // url()/asset() emit https:// and avoid the mixed-content block.
        $middleware->trustProxies(at: '*', headers:
            Request::HEADER_X_FORWARDED_FOR
            | Request::HEADER_X_FORWARDED_HOST
            | Request::HEADER_X_FORWARDED_PORT
            | Request::HEADER_X_FORWARDED_PROTO
            | Request::HEADER_X_FORWARDED_AWS_ELB
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

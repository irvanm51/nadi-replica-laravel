<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'teleport.auth' => \App\Http\Middleware\TeleportAuthenticate::class,
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        // Point at the Teleport proxy/agent so $request->ip()/secure() reflect
        // the real client once requests arrive via that proxy. This is a
        // separate concern from TeleportAuthenticate's own trusted-peer check,
        // which deliberately inspects the raw, unrewritten REMOTE_ADDR.
        $middleware->trustProxies(
            at: array_filter(explode(',', (string) env('TELEPORT_TRUSTED_PROXY_CIDRS', ''))),
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();

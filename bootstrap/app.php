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
            'jwt.cookie' => \App\Http\Middleware\JwtCookieAuthenticate::class,
            'guest.jwt' => \App\Http\Middleware\RedirectIfJwtAuthenticated::class,
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        // The JWT cookie must stay a genuine, undecorated JWT (not Laravel's
        // encrypted cookie format) so JwtCookieAuthenticate can hand it
        // straight to JWTAuth, and so it's decodable for demo/verification.
        $middleware->encryptCookies(except: [
            env('JWT_COOKIE_NAME', 'nadi_token'),
        ]);

        // Production sits behind a reverse proxy (nginx/Caddy/Traefik on the
        // VPS) that terminates TLS and forwards to this app over plain HTTP.
        // Without trusting it, $request->secure() and route()/redirect()
        // always resolve to http:// here — APP_URL alone does not fix this
        // for URLs generated during a real request. '*' is used because the
        // proxy's address as seen by the container isn't fixed/known; this
        // is safe only as long as the app isn't also reachable directly,
        // bypassing that proxy (e.g. bind the published port to 127.0.0.1).
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();

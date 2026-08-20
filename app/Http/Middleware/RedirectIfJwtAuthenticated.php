<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class RedirectIfJwtAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie(config('nadi.jwt_cookie_name'));

        if ($token) {
            try {
                JWTAuth::setToken($token);
                $user = JWTAuth::authenticate();

                if ($user) {
                    return redirect()->route($user->role === 'staf' ? 'staf.dashboard' : 'dosen.dashboard');
                }
            } catch (\Throwable $e) {
                // Invalid/expired token: fall through and show the guest page.
            }
        }

        return $next($request);
    }
}

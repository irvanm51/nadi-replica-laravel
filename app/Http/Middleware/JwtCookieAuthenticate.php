<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtCookieAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie(config('nadi.jwt_cookie_name'));

        if (! $token) {
            return redirect()->route('login');
        }

        try {
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();

            if (! $user) {
                return redirect()->route('login');
            }

            Auth::guard('api')->setUser($user);
        } catch (TokenExpiredException $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Sesi berakhir, silakan login kembali.'])
                ->withCookie(Cookie::forget(config('nadi.jwt_cookie_name')));
        } catch (JWTException $e) {
            return redirect()->route('login')
                ->withCookie(Cookie::forget(config('nadi.jwt_cookie_name')));
        }

        return $next($request);
    }
}

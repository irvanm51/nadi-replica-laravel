<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        CaptchaController::generate();

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'captcha_answer' => ['required', 'numeric'],
        ]);

        $captchaValid = (int) $request->input('captcha_answer') === (int) session('captcha_answer');

        // Never let a captcha equation be reused, whether the attempt below succeeds or not.
        CaptchaController::generate();

        if (! $captchaValid) {
            return back()
                ->withErrors(['captcha_answer' => 'Jawaban verifikasi keamanan salah.'])
                ->withInput($request->except('password', 'captcha_answer'));
        }

        $remember = $request->boolean('remember');
        $ttl = $remember ? config('jwt.refresh_ttl') : config('jwt.ttl');

        $token = Auth::guard('api')->setTTL($ttl)->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ]);

        if (! $token) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput($request->except('password', 'captcha_answer'));
        }

        $user = Auth::guard('api')->user();

        $cookie = cookie(
            config('nadi.jwt_cookie_name'),
            $token,
            $ttl,
            '/',
            null,
            $request->secure(),
            true,
            false,
            'Lax'
        );

        return redirect()
            ->route($user->role === 'staf' ? 'staf.dashboard' : 'dosen.dashboard')
            ->withCookie($cookie);
    }

    public function logout(Request $request): RedirectResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (\Throwable $e) {
            // Token already invalid/expired — nothing to invalidate.
        }

        return redirect()
            ->route('login')
            ->withCookie(Cookie::forget(config('nadi.jwt_cookie_name')));
    }
}

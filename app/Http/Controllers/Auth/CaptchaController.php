<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CaptchaController extends Controller
{
    /**
     * Generate a new random math captcha and store its answer in the session.
     */
    public static function generate(): void
    {
        $a = random_int(10, 50);
        $b = random_int(10, 60);

        session([
            'captcha_a' => $a,
            'captcha_b' => $b,
            'captcha_answer' => $a + $b,
        ]);
    }

    /**
     * Regenerate the captcha and return just the captcha widget markup,
     * so the client can swap it in without a full page reload.
     */
    public function refresh(Request $request): View
    {
        self::generate();

        return view('components.captcha-box');
    }
}

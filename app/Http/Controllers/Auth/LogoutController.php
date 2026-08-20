<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class LogoutController extends Controller
{
    public function logout(): RedirectResponse
    {
        // Teleport owns the real session; this app can't end it directly.
        return redirect(config('teleport.logout_url'));
    }
}

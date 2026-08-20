<?php

return [

    /*
    |--------------------------------------------------------------------------
    | JWT Cookie Name
    |--------------------------------------------------------------------------
    |
    | Name of the httpOnly cookie that carries the JWT issued on login, so
    | Blade page navigation can authenticate without an Authorization header.
    |
    */

    'jwt_cookie_name' => env('JWT_COOKIE_NAME', 'nadi_token'),

];

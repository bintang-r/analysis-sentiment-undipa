<?php

return [
    'roles' => [
        'superadmin',
        'developer',
        'admin',
        'user',
    ],

    "logo" => [
        "light" => env("LOGO_LIGHT", 'ryoogenmedia/logo/LOGO 1.svg'),
        "transparent" => env("LOGO_TRANSPARENT", 'ryoogenmedia/logo/LOGO 2.svg'),
        "dark" => env('LOGO_DARK', 'ryoogenmedia/logo/LOGO 3.svg'),
    ],

    'app_name' => env('APP_NAME', 'Ryoogen Pungawa Media'),
];

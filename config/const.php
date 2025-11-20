<?php

return [
    'roles' => [
        'admin',
        'user',
    ],

    'visible_roles' => [
        'admin',
        'user',
    ],

    "logo" => [
        "light" => env("LOGO_LIGHT", 'sentinova/logo/LOGO.png'),
        "transparent" => env("LOGO_TRANSPARENT", 'sentinova/logo/LOGO.png'),
        "dark" => env('LOGO_DARK', 'sentinova/logo/LOGO.png'),
    ],

    'app_name' => env('APP_NAME', 'Ryoogen Pungawa Media'),

    'developer_user' => [
        'muhbintang650@gmail.com',
        'feryfadulrahman@gmail.com',
        'akbar@gmail.com',
        'ugha@gmail.com',
    ],

    'sentiment_status' => [
        'netral',
        'negatif',
        'positif',
        'async',
    ],

    'periods' => [
        'daily',
        'weekly',
        'monthly',
        'yearly',
    ],
];

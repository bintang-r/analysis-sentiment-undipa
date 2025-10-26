<?php

return [
    [
        'title' => 'Beranda',
        'icon' => 'home',
        'route-name' => 'home',
        'is-active' => 'home',
        'description' => 'Untuk melihat ringkasan aplikasi.',
        'roles' => ['developer', 'superadmin', 'admin', 'user'],
    ],

    [
        'title' => 'Data Komentar',
        'icon' => 'comment',
        'route-name' => 'comment.index',
        'is-active' => 'comment*',
        'description' => 'Untuk melihat semua data komentar.',
        'roles' => ['developer', 'superadmin', 'admin'],
    ],

    [
        'title' => 'Pengguna',
        'icon' => 'user',
        'route-name' => 'user.index',
        'is-active' => 'user.index',
        'description' => 'Untuk melihat pengguna aplikasi.',
        'roles' => ['developer', 'superadmin', 'admin'],
    ],

    [
        'title' => 'Pengaturan',
        'description' => 'Menampilkan pengaturan aplikasi.',
        'icon' => 'cog',
        'route-name' => 'setting.profile.index',
        'is-active' => 'setting*',
        'roles' => ['developer', 'superadmin', 'admin', 'user'],
        'sub-menus' => [
            [
                'title' => 'Profil',
                'description' => 'Melihat pengaturan profil.',
                'route-name' => 'setting.profile.index',
                'is-active' => 'setting.profile*',
            ],
            [
                'title' => 'Akun',
                'description' => 'Melihat pengaturan akun.',
                'route-name' => 'setting.account.index',
                'is-active' => 'setting.account*',
            ],
        ],
    ],
];

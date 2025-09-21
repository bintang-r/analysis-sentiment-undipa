<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $developer = [
            [
                'username' => 'Bintang Dev',
                'email' => 'muhbintang650@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('bintang123'),
                'role' => 'developer',
            ],
            [
                'username' => 'Fery Dev',
                'email' => 'feryfadulrahman@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('fery123'),
                'role' => 'developer',
            ],
            [
                'username' => 'Akbar Dev',
                'email' => 'akbar@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('akbar123'),
                'role' => 'developer',
            ],
            [
                'username' => 'Ugha Dev',
                'email' => 'ugha@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('ugha123'),
                'role' => 'developer',
            ]
        ];

        $testUser = [
            [
                'username' => 'Test Admin',
                'email' => 'testadmin@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('test123'),
                'role' => 'admin',
            ],
            [
                'username' => 'Test Superadmin',
                'email' => 'testsuperadmin@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('test123'),
                'role' => 'superadmin',
            ],
            [
                'username' => 'Test User',
                'email' => 'testuser@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('test123'),
                'role' => 'user',
            ],
        ];

        foreach ($developer as $user) {
            User::create($user);
        }

        foreach ($testUser as $user) {
            User::create($user);
        }
    }
}

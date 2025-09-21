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
        $users = [
            [
                'username' => 'Bintang Admin',
                'email' => 'muhbintang650@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('bintang123'),
                'role' => 'developer',
            ],
            [
                'username' => 'Fery Admin',
                'email' => 'feryfadulrahman@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('fery123'),
                'role' => 'developer',
            ],
            [
                'username' => 'Akbar Admin',
                'email' => 'akbaradmin123@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('akbar123'),
                'role' => 'developer',
            ],
            [
                'username' => 'Ugha Admin',
                'email' => 'ugha@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('ugha123'),
                'role' => 'developer',
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

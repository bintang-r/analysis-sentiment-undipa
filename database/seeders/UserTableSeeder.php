<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $testUser = [
            [
                'username_232187' => 'Reyhan Renaldy',
                'email_232187' => 'hansekuy15@gmail.com',
                'email_verified_at_232187' => now(),
                'password_232187' => bcrypt('reyhan123'),
                'role_232187' => 'admin',
            ],
            [
                'username_232187' => 'Test User',
                'email_232187' => 'testuser@gmail.com',
                'email_verified_at_232187' => now(),
                'password_232187' => bcrypt('test123'),
                'role_232187' => 'user',
            ],
        ];

        foreach ($testUser as $user) {
            User::create($user);
        }
    }
}

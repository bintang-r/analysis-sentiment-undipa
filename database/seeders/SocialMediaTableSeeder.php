<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Seeder;

class SocialMediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $social_medias = [
            [
                'name' => 'tiktok',
                'is_active' => true,
            ],
            [
                'name' => 'x (twitter)',
                'is_active' => true,
            ],
            [
                'name' => 'instagram',
                'is_active' => true,
            ],
            [
                'name' => 'facebook',
                'is_active' => false,
            ]
        ];

        foreach ($social_medias as $social_media) {
            SocialMedia::create($social_media);
        }
    }
}

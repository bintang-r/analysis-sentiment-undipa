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
                'name_232187' => 'tiktok',
                'is_active_232187' => true,
            ],
            [
                'name_232187' => 'x (twitter)',
                'is_active_232187' => true,
            ],
            [
                'name_232187' => 'instagram',
                'is_active_232187' => true,
            ],
            [
                'name_232187' => 'facebook',
                'is_active_232187' => false,
            ]
        ];

        foreach ($social_medias as $social_media) {
            SocialMedia::create($social_media);
        }
    }
}

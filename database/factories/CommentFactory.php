<?php

namespace Database\Factories;

use App\Models\SocialMedia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck('id_232187')->toArray();
        $status = config('const.sentiment_status');
        $socialMediaIds = SocialMedia::pluck('id_232187')->toArray();

        return [
            'user_id_232187'         => $this->faker->randomElement($userIds),
            'social_media_id_232187' => $this->faker->randomElement($socialMediaIds),
            'comment_232187'         => $this->faker->sentence(10),
            'status_232187'          => $this->faker->randomElement($status),
        ];
    }
}

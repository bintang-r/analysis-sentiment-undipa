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
        $userIds = User::pluck('id')->toArray();
        $status = config('const.sentiment_status');
        $socialMediaIds = SocialMedia::pluck('id')->toArray();

        return [
            'user_id'         => $this->faker->randomElement($userIds),
            'social_media_id' => $this->faker->randomElement($socialMediaIds),
            'comment'         => $this->faker->sentence(10),
            'status'          => $this->faker->randomElement($status),
        ];
    }
}

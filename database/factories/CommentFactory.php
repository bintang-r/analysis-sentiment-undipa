<?php

namespace Database\Factories;

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
        return [
            'user_id' => $this->faker->randomElement($userIds),
            'comment' => $this->faker->sentence(10),
            'status'  => $this->faker->randomElement($status),
        ];
    }
}

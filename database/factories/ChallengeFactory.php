<?php

namespace Database\Factories;

use App\Models\Challenge;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Challenge>
 */
class ChallengeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'user_id' => User::factory(),
            'is_success' => fake()->boolean(),
        ];
    }

    /**
     *  チャレンジ成功
     */
    public function success(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_success' => true,
        ]);
    }

    /**
     *  チャレンジ失敗
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_success' => false,
        ]);
    }
}

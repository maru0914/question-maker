<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->realText(300),
            'image_path' => null,
        ];
    }

    /**
     * 画像未登録
     */
    public function withImage(): static
    {
        if (! Storage::disk('public')->exists('images')) {
            Storage::disk('public')->makeDirectory('images');
        }

        return $this->state(fn (array $attributes) => [
            'image_path' => 'images/'.fake()->image(storage_path('app/public/images'), 640, 480, null, false),
        ]);
    }


}

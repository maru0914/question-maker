<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
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
     * 画像登録あり
     */
    public function withImage(): static
    {
        $stubFile = new File(Storage::disk('local')->path('stub/laravel-logo.png'));
        $filePath = Storage::disk('public')->putFile('images', $stubFile);

        return $this->state(fn (array $attributes) => [
            'image_path' => $filePath,
        ]);
    }


}

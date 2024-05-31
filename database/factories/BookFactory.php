<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

/**
 * @extends Factory<Book>
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
            'title' => fake()->realtext(20),
            'description' => fake()->realText(300),
            'image_path' => null,
        ];
    }

    /**
     * 画像登録あり
     */
    public function withImage(string $path = 'stub/laravel-logo.png'): static
    {
        $stubFile = new File(Storage::disk('local')->path($path));
        $filePath = Storage::disk('public')->putFile('images', $stubFile);

        return $this->state(fn (array $attributes) => [
            'image_path' => $filePath,
        ]);
    }


}

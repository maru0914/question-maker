<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'body' => fake()->text(),
            'answer' => fake()->text(),
            'default_order' => 1,
        ];
    }
}

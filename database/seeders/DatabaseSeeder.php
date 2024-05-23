<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Challenge;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::delete(Storage::files('public/images'));

        $testUser = User::factory()->create([
            'username' => 'testuser1234',
            'email' => 'test@example.com',
        ]);

        $users = User::factory(10)->create();

        $books = Book::factory(21)
            ->withImage()
            ->recycle($users)
            ->sequence(fn (Sequence $sequence) => ['title' => '問題集'.$sequence->index + 1])
            ->create();

        foreach ($books as $book) {
            $questions = Question::factory(3)
                ->for($book)
                ->sequence(fn (Sequence $sequence) => [
                    'body' => '地球と月はどちらが大きいですか？'.$sequence->index + 1,
                    'answer' => '地球です。月の直径は地球の約1/4、質量は約1/81です。'.$sequence->index + 1,
                    'default_order' => $sequence->index + 1,
                ])
                ->create();

            Challenge::factory(10)
                ->recycle($questions)
                ->recycle($users)
                ->create();
        }

        $testBook = Book::factory()
            ->withImage()
            ->for($testUser)
            ->has(
                Question::factory(3)
                    ->sequence(
                        [
                            'body' => 'PHPがリリースされた年は？',
                            'answer' => '1995年です。',
                            'default_order' => 1,
                        ],
                        [
                            'body' => 'Laravelがリリースされた年は？',
                            'answer' => '2011年です。',
                            'default_order' => 2,
                        ],
                        [
                            'body' => 'Symphonyがリリースされた年は？',
                            'answer' => '2005年です。',
                            'default_order' => 3,
                        ],
                    )
            )
            ->create([
                'title' => 'PHP雑学',
                'description' => 'PHPに関連する雑学についての問題集です。',
            ]);

        // テストユーザーが作成した問題にテストユーザーでチャレンジ
        Challenge::factory(2)
            ->for($testUser)
            ->recycle($testBook->questions)
            ->create();

        // テストユーザーが作成した問題に他ユーザーがチャレンジ
        Challenge::factory(10)
            ->recycle($users)
            ->recycle($testBook->questions)
            ->create();

        // 他ユーザーが作成した問題にテストユーザーがチャレンジ
        Challenge::factory(10)
            ->recycle($testUser)
            ->recycle(Question::all())
            ->create();
    }
}

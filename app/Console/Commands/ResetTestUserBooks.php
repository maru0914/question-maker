<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\Question;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResetTestUserBooks extends Command
{
    public const TEST_USER_ID = 1;

    protected $signature = 'reset:test-user-books';

    protected $description = "reset test user's books except default book.";

    public function handle(): void
    {
        Log::info("[START] reset test user's books.");

        DB::transaction(function () {
            $this->deleteBooks();
            $this->createDefaultBooks();
        });

        Log::info("[END] reset test user's books.");
    }

    protected function deleteBooks(): void
    {
        $targetBooks = Book::query()
            ->where('user_id', self::TEST_USER_ID)
            ->get();

        foreach ($targetBooks as $targetBook) {
            $targetBook->questions()->delete();
            $result = $targetBook->delete();
            if ($result) {
                Log::info("Deleted book_id: $targetBook->id");
            }
        }
    }

    protected function createDefaultBooks(): void
    {
        Book::factory()
            ->withImage('stub/php-logo.png')
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
                'user_id' => self::TEST_USER_ID,
                'title' => 'PHP雑学',
                'description' => 'PHPに関連する雑学についての問題集です。',
            ]);
    }
}

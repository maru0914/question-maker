<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CleanUpTestUserBooks extends Command
{
    public const DEFAULT_BOOK_ID = 8; // 削除対象外

    public const TEST_USER_ID = 1;

    protected $signature = 'clean:test-user-books';

    protected $description = 'cleanup test user books except default book.';

    public function handle(): void
    {
        Log::info("[START] cleanup test user's books.");

        $targetBooks = Book::query()
            ->where('user_id', self::TEST_USER_ID)
            ->whereNot('id', self::DEFAULT_BOOK_ID)
            ->get();

        Log::info("{$targetBooks->count()} books were detected.");

        $deletedBookCount = 0;
        foreach ($targetBooks as $targetBook) {
            DB::transaction(function () use ($targetBook, &$deletedBookCount) {
                $targetBook->questions()->delete();
                $result = $targetBook->delete();
                if ($result) {
                    $deletedBookCount++;
                    Log::info("Deleted book_id: $targetBook->id");
                }
            });
        }

        Log::info("$deletedBookCount books were deleted.");

        Log::info("[END] cleanup test user's books.");
    }
}

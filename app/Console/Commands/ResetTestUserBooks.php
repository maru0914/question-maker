<?php

namespace App\Console\Commands;

use App\Exceptions\StorageException;
use App\Models\Book;
use App\Models\Question;
use App\Services\ImageService;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ResetTestUserBooks extends Command
{
    public const TEST_USER_ID = 1;

    protected $signature = 'reset:test-user-books';

    protected $description = "reset test user's books except default book.";

    public function __construct(protected ImageService $imageService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        Log::info("[START] reset test user's books.");

        DB::transaction(function () {
            $this->deleteBooks();
            $this->createDefaultBooks();
        });

        Log::info("[END] reset test user's books.");
    }

    /**
     * @throws StorageException
     */
    protected function deleteBooks(): void
    {
        $targetBooks = Book::query()
            ->where('user_id', self::TEST_USER_ID)
            ->get();

        foreach ($targetBooks as $targetBook) {
            $targetBook->questions()->delete();
            if ($targetBook->image_path) {
                $this->imageService->delete($targetBook->image_path);
            }
            $result = $targetBook->delete();
            if ($result) {
                Log::info("Deleted book_id: $targetBook->id");
            }
        }
    }

    protected function createDefaultBooks(): void
    {
        $stubFile = new File(Storage::disk('local')->path('stub/php-logo.png'));
        $filePath = Storage::disk('public')->putFile('images', $stubFile);

        $book = Book::create([
            'user_id' => self::TEST_USER_ID,
            'title' => 'PHP雑学',
            'description' => 'PHPに関連する雑学についての問題集です。',
            'image_path' => $filePath,
        ]);

        Question::insert([
            [
                'book_id' => $book->id,
                'body' => 'PHPがリリースされた年は？',
                'answer' => '1995年です。',
                'default_order' => 1,
            ],
            [
                'book_id' => $book->id,
                'body' => 'Laravelがリリースされた年は？',
                'answer' => '2011年です。',
                'default_order' => 2,
            ],
            [
                'book_id' => $book->id,
                'body' => 'Symphonyがリリースされた年は？',
                'answer' => '2005年です。',
                'default_order' => 3,
            ],
        ]);
    }
}

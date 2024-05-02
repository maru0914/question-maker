<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\Question;
use App\Models\User;
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

        $users = User::factory(10)->create();

        for ($i = 1; $i <= 21; $i++) {
            Question::factory()->recycle($users)->create([
                'body' => '地球と月はどちらが大きいですか？'.$i,
                'answer' => '地球です。月の直径は地球の約1/4、質量は約1/81です。'.$i,
            ]);
        }

        for ($i = 1; $i <= 21; $i++) {
            Book::factory()->recycle($users)->create([
                'title' => '問題集'.$i,
            ]);
        }

        $testUser = User::factory()->create([
            'username' => 'testuser1234',
            'email' => 'test@example.com',
        ]);

        Question::factory()
            ->for($testUser)
            ->count(3)
            ->sequence(
                [
                    'body' => 'PHPがリリースされた年は？',
                    'answer' => '1995年です。',
                ],
                [
                    'body' => 'Laravelがリリースされた年は？',
                    'answer' => '2011年です。',
                ],
                [
                    'body' => 'Symphonyがリリースされた年は？',
                    'answer' => '2005年です。',
                ],
            )
            ->create();
    }
}

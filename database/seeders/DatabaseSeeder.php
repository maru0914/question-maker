<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $testUser = User::factory()->create([
            'name' => 'Test User',
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

        for ($i = 1; $i <= 21; $i++) {
            Question::factory()->create([
                'body' => '地球と月はどちらが大きいですか？'.$i,
                'answer' => '地球です。月の直径は地球の約1/4、質量は約1/81です。'.$i,
            ]);
        }
    }
}

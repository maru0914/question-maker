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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Question::factory()
            ->create([
                'body' => '地球と月はどちらが大きいですか？',
                'answer' => '地球です。月の直径は地球の約1/4、質量は約1/81です。',
            ]);

        Question::factory()
            ->create([
                'body' => '地球と火星はどちらが大きいですか？',
                'answer' => '地球です。火星の直径は地球の約1/2、質量は約1/10です。',
            ]);
    }
}

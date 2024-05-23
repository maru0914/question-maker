<?php

use App\Console\Commands\CleanUpTestUserBooks;
use App\Models\Book;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

it('テストユーザーの問題集を削除できる', function () {
    $book = Book::factory()
        ->for(User::factory()->create(['id' => CleanUpTestUserBooks::TEST_USER_ID]))
        ->create();

    $this->artisan('clean:test-user-books');

    $this->assertModelMissing($book);
});

it('デフォルト表示する問題集は削除されない', function () {
    $book = Book::factory()
        ->for(User::factory()->create(['id' => CleanUpTestUserBooks::TEST_USER_ID]))
        ->create(['id' => CleanUpTestUserBooks::DEFAULT_BOOK_ID]);

    $this->artisan('clean:test-user-books');

    $this->assertModelExists($book);
});

it('問題集に紐づく問題も削除される', function () {
    Book::factory()
        ->for(User::factory()->create(['id' => CleanUpTestUserBooks::TEST_USER_ID]))
        ->has(Question::factory()
            ->sequence(fn (Sequence $sequence) => ['default_order' => $sequence->index + 1]))
        ->create();

    $this->artisan('clean:test-user-books');

    $this->assertDatabaseCount('questions', 0);
});

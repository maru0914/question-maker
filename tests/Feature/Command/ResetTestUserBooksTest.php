<?php

use App\Console\Commands\ResetTestUserBooks;
use App\Models\Book;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

beforeEach(function () {
    $this->testUser = User::factory(['id' => ResetTestUserBooks::TEST_USER_ID])->create();
});

it('テストユーザーに紐付く問題集を削除できる', function () {
    $book = Book::factory()
        ->for($this->testUser)
        ->create();

    $this->artisan('reset:test-user-books');

    $this->assertModelMissing($book);
});

it('デフォルト表示する問題集が作られる', function () {

    $this->artisan('reset:test-user-books');

    $this->assertDatabaseHas('books', [
        'user_id' => $this->testUser->id,
        'title' => 'PHP雑学',
    ]);
});

it('問題集に紐づく問題も削除される', function () {
    $book = Book::factory()
        ->for($this->testUser)
        ->has(Question::factory()
            ->sequence(fn (Sequence $sequence) => ['default_order' => $sequence->index + 1]))
        ->create();

    $this->artisan('reset:test-user-books');

    $this->assertDatabaseMissing('questions', [
        'book_id' => $book->id,
    ]);
});

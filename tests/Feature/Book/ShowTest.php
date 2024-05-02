<?php

use App\Models\Book;

beforeEach(function () {
    $this->book = Book::factory()->create();
});

test('登録されている内容を閲覧できる', function () {
    $this->get("/books/{$this->book->id}")
        ->assertOk()
        ->assertSee($this->book->title)
        ->assertSee($this->book->description);
});

test('idが存在しない場合、404を返す', function () {
    $latestBook = Book::orderBy('id', 'desc')->first();
    $nonExistingId = $latestBook->id + 1;

    $this->get("/books/{$nonExistingId}")
        ->assertNotFound();
});


<?php

use App\Http\Resources\BookResource;
use App\Models\Book;

beforeEach(function () {
    $this->book = Book::factory()->create();
});

test('bookがコンポーネントに渡される', function () {
    $this->get("/books/{$this->book->id}")
        ->assertHasResource('book', BookResource::make($this->book));
});

test('idが存在しない場合、404を返す', function () {
    $latestBook = Book::orderBy('id', 'desc')->first();
    $nonExistingId = $latestBook->id + 1;

    $this->get("/books/{$nonExistingId}")
        ->assertNotFound();
});

<?php

use App\Http\Controllers\BookController;
use App\Http\Resources\BookResource;
use App\Models\Book;

covers(BookController::class);

test('問題集が登録されていない場合リストが表示されない', function () {
    $this->get('/books')
        ->assertOK()
        ->assertDontSee('編集');
});

test('booksがコンポーネントに渡される', function () {
    $books = Book::factory(3)->create();

    $books->load('user');

    $this->get(route('books.index'))
        ->assertHasPaginatedResource('books', BookResource::collection($books->reverse()));
});

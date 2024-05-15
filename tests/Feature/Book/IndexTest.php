<?php

use App\Http\Resources\BookResource;
use App\Models\Book;

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

test('クエリパラメータpageが数値以外の場合1ページ目の内容が表示される', function () {
    $book = Book::factory()->create();

    $this->get('/books?page=abc')
        ->assertOK()
        ->assertSee($book->title);
});

test('作成の新しい順に問題集が表示される', function () {
    $book1 = Book::factory()->create();
    $book2 = Book::factory()->create();

    $this->get(route('books.index'))
        ->assertOK()
        ->assertSeeInOrder([$book2->title, $book1->title]);
});

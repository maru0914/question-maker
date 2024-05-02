<?php

use App\Models\Book;
use Illuminate\Support\Facades\Storage;

test('問題集が登録されていない場合リストが表示されない', function () {
    $this->get('/books')
        ->assertOK()
        ->assertDontSee('編集');
});

test('問題集が登録されている場合リストが表示される', function () {
    $book = Book::factory()->create();

    $this->get('/books')
        ->assertOK()
        ->assertViewHas('books', function ($books) {
            return count($books) === 1;
        })
        ->assertSee($book->title);
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

    $this->get('/books')
        ->assertOK()
        ->assertSeeInOrder([$book2->title, $book1->title]);
});

describe('ページネーションのテスト', function () {
    test('登録されている問題集が20件以下の場合ページネーションが表示されない', function () {
        Storage::fake('public');
        Book::factory()->count(20)->create();

        $this->get('/books')
            ->assertOK()
            ->assertViewHas('books', function ($books) {
                return count($books) === 20;
            })
            ->assertDontSee('/books?page=');
    });

    test('登録されている問題集が21件以上の場合ページネーションが表示される', function () {
        Book::factory()->count(21)->create();

        $this->get('/books')
            ->assertOK()
            ->assertViewHas('books', function ($books) {
                return count($books) === 20;
            })
            ->assertSee('/books?page=2');
    });

    test('2ページ目以降にいる場合前のページへのリンクが表示される', function () {
        Book::factory()->count(21)->create();

        $this->get('/books?page=2')
            ->assertOK()
            ->assertSee('/books?page=1');
    });

    test('存在しないページ数にアクセスした場合も前のページへのリンクが表示される', function () {
        $this->get('/books?page=2')
            ->assertOk()
            ->assertSee('/books?page=1');
    });
});

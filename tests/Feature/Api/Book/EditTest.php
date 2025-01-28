<?php

use App\Http\Controllers\BookController;
use App\Models\Book;
use App\Models\User;

covers(BookController::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->book = Book::factory()->for($this->user)->create();
});

test('編集画面にアクセスできる', function () {
    $this->actingAs($this->user)
        ->get("/books/{$this->book->id}/edit")
        ->assertOk();
});

test('他ユーザーが作成した問題の編集画面はアクセスできない', function () {
    $bookByOtherUser = Book::factory()->create();

    $this->actingAs($this->user)
        ->get("/books/{$bookByOtherUser->id}/edit")
        ->assertForbidden();
});

test('idが存在しない場合、404を返す', function () {
    $latestBook = Book::orderBy('id', 'desc')->first();
    $nonExistingId = $latestBook->id + 1;

    $this->actingAs($this->user)
        ->get("/books/{$nonExistingId}/edit")
        ->assertNotFound();
});

test('ログインしていない場合ログインページにリダイレクト', function () {
    $this->get("/books/{$this->book->id}/edit")
        ->assertRedirect('/login');
});

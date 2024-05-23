<?php

use App\Models\Book;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->book = Book::factory()->for($this->user)->create();
});

test('問題を削除できる', function () {
    $this->actingAs($this->user)
        ->delete("/books/{$this->book->id}")
        ->assertRedirect('/books');

    $this->assertDatabaseMissing('books', [
        'id' => $this->book->id,
    ]);
});

test('他ユーザーが作成した問題は削除できない', function () {
    $bookByOtherUser = Book::factory()->create();

    $this->actingAs($this->user)
        ->delete("/books/{$bookByOtherUser->id}")
        ->assertForbidden();

    $this->assertDatabaseHas('books', [
        'id' => $bookByOtherUser->id,
    ]);
});

test('存在しないidを指定した場合404を返す', function () {
    $latestBook = Book::orderBy('id', 'desc')->first();
    $nonExistingId = $latestBook->id + 1;

    $this->actingAs($this->user)
        ->delete("/books/{$nonExistingId}")
        ->assertNotFound();
});

test('ログインしていない場合ログインページにリダイレクト', function () {
    $this->delete("/books/{$this->book->id}")
        ->assertRedirect('/login');
});

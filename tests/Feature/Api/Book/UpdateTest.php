<?php

use App\Http\Controllers\BookController;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\UploadedFile;

covers(BookController::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->book = Book::factory()->for($this->user)->create();
    $this->requestData = [
        'title' => '問題集のタイトル',
        'description' => '問題集の説明文',
    ];
});

test('問題集を更新できる', function () {
    $this->actingAs($this->user)
        ->patch("/books/{$this->book->id}", $this->requestData)
        ->assertRedirect('/books');
    $this->assertDatabaseHas('books', [
        'id' => $this->book->id,
        ...$this->requestData,
    ]);
});

test('画像を更新できる', function () {
    Storage::fake('public');
    $book = Book::factory()->withImage()->for($this->user)->create();
    $oldImagePath = $book->image_path;

    $this->actingAs($this->user)
        ->patch("/books/{$book->id}", [
            ...$this->requestData,
            'image' => UploadedFile::fake()->image('test.jpg'),
        ])
        ->assertRedirect('/books');

    $book->refresh();

    $this->assertDatabaseHas('books', [
        'id' => $book->id,
        ...$this->requestData,
    ]);

    Storage::disk('public')->assertExists($book->image_path);
    Storage::disk('public')->assertMissing($oldImagePath);
});

test('他ユーザーが作成した問題集は更新できない', function () {
    $bookByOtherUser = Book::factory()->create();

    $this->actingAs($this->user)
        ->patch("/books/{$bookByOtherUser->id}", $this->requestData)
        ->assertForbidden();

    $this->assertDatabaseMissing('books', [
        'id' => $this->book->id,
        ...$this->requestData,
    ]);
});

test('更新が失敗した場合元のページに戻る', function () {
    $this->actingAs($this->user)
        ->from("/books/{$this->book->id}/edit")
        ->patch("/books/{$this->book->id}", [])
        ->assertRedirect("/books/{$this->book->id}/edit");
});

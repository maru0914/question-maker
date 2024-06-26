<?php

use App\Models\Book;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->requestData = [
        'body' => '問題を登録する',
        'answer' => '答え',
        'book_id' => Book::factory()->create()->id,
    ];
});

test('問題を登録できる', function () {
    $this->actingAs($this->user)
        ->post('/questions', $this->requestData)
        ->assertRedirect("/books/{$this->requestData['book_id']}");

    $this->assertDatabaseHas('questions', $this->requestData);
});

test('登録が失敗した場合元のページに戻る', function () {
    $this->actingAs($this->user)
        ->from("/books/{$this->requestData['book_id']}")
        ->post('/questions', [])
        ->assertRedirect("/books/{$this->requestData['book_id']}");
});

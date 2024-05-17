<?php

use App\Models\Book;
use App\Models\Question;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->book = Book::factory()->for($this->user)->create();
    $this->question = Question::factory()->for($this->user)->for($this->book)->create();
    $this->anotherBook = Book::factory()->for($this->user)->create();
    $this->requestData = [
        'body' => '１＋１は？',
        'answer' => '田んぼの田',
    ];
});

test('問題を更新できる', function () {
    $this->actingAs($this->user)
        ->patch("/questions/{$this->question->id}", $this->requestData)
        ->assertRedirect("/questions/{$this->question->id}");

    $this->assertDatabaseHas('questions', [
        'id' => $this->question->id,
        'body' => $this->requestData['body'],
        'answer' => $this->requestData['answer'],
        'book_id' => $this->question->book_id,
    ]);
});

test('他ユーザーが作成した問題は更新できない', function () {
    $questionByOtherUser = Question::factory()->create();

    $this->actingAs($this->user)
        ->patch("/questions/{$questionByOtherUser->id}", $this->requestData)
        ->assertForbidden();
    $this->assertDatabaseMissing('questions', [
        'id' => $this->question->id,
        'body' => $this->requestData['body'],
        'answer' => $this->requestData['answer'],
        'book_id' => $this->question->book_id,
    ]);
});

test('更新が失敗した場合元のページに戻る', function () {
    $this->actingAs($this->user)
        ->from("/questions/{$this->question->id}/edit")
        ->patch("/questions/{$this->question->id}", [])
        ->assertRedirect("/questions/{$this->question->id}/edit");
});

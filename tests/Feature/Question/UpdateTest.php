<?php

use App\Models\Question;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->question = Question::factory()->for($this->user)->create();
});

test('問題を更新できる', function () {
    $requestData = [
        'body' => '１＋１は？',
        'answer' => '田んぼの田',
    ];

    $this->actingAs($this->user)
        ->patch("/questions/{$this->question->id}", $requestData)
        ->assertRedirect('/questions');
    $this->assertDatabaseHas('questions', [
        'id' => $this->question->id,
        'body' => $requestData['body'],
        'answer' => $requestData['answer'],
    ]);
});

test('他ユーザーが作成した問題は更新できない', function () {
    $requestData = [
        'body' => '１＋１は？',
        'answer' => '田んぼの田',
    ];

    $questionByOtherUser = Question::factory()->create();

    $this->actingAs($this->user)
        ->patch("/questions/{$questionByOtherUser->id}", $requestData)
        ->assertForbidden();
    $this->assertDatabaseMissing('questions', [
        'id' => $this->question->id,
        'body' => $requestData['body'],
        'answer' => $requestData['answer'],
    ]);
});

test('更新が失敗した場合元のページに戻る', function () {
    $this->actingAs($this->user)
        ->from("/questions/{$this->question->id}/edit")
        ->patch("/questions/{$this->question->id}", [])
        ->assertRedirect("/questions/{$this->question->id}/edit");
});

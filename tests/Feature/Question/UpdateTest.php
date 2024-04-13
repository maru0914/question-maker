<?php

use App\Models\Question;
use App\Models\User;

beforeEach(function () {
    $this->question = Question::factory()->create();
    $this->user = User::factory()->create();
});

test('問題を更新できる', function () {
    $requestData = [
        'body' => '１＋１は？',
        'answer' => '田んぼの田',
    ];

    $this->actingAs($this->user)
        ->put("/questions/{$this->question->id}", $requestData)
        ->assertRedirect('/questions');
    $this->assertDatabaseHas('questions', [
        'id' => $this->question->id,
        'body' => $requestData['body'],
        'answer' => $requestData['answer'],
    ]);
});

test('更新が失敗した場合元のページに戻る', function () {
    $this->actingAs($this->user)
        ->from("/questions/{$this->question->id}/edit")
        ->put("/questions/{$this->question->id}", [])
        ->assertRedirect("/questions/{$this->question->id}/edit");
});

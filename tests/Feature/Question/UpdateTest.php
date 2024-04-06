<?php

use App\Models\Question;

beforeEach(function () {
    $this->question = Question::factory()->create();
});

test('questionを更新できる', function () {
    $requestData = [
        'body' => '１＋１は？',
        'answer' => '田んぼの田',
    ];

    $this->put("/questions/{$this->question->id}", $requestData)
        ->assertRedirect('/questions');
    $this->assertDatabaseHas('questions', [
        'id' => $this->question->id,
        'body' => $requestData['body'],
        'answer' => $requestData['answer'],
    ]);
});

test('更新が失敗した場合元のページに戻る', function () {
    $this->from("/questions/{$this->question->id}/edit")
        ->put("/questions/{$this->question->id}", [])
        ->assertRedirect("/questions/{$this->question->id}/edit");
});

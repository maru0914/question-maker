<?php

use App\Models\Question;

beforeEach(function () {
    $this->question = Question::factory()->create();
});

test('問題を削除できる', function () {
    $this->delete("/questions/{$this->question->id}")
        ->assertRedirect('/questions');

    $this->assertDatabaseMissing('questions', [
        'id' => $this->question,
    ]);
});

test('存在しないidを指定した場合404を返す', function () {
    $latestQuestion = Question::orderBy('id', 'desc')->first();
    $nonExistingId = $latestQuestion->id + 1;

    $this->delete("/questions/{$nonExistingId}")
        ->assertNotFound();
});

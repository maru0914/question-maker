<?php

use App\Models\Question;

beforeEach(function () {
    $this->question = Question::factory()->create();
});

test('削除が成功すると/questionsにリダイレクトする', function () {
    $response = $this->delete("/questions/{$this->question->id}");

    expect(Question::find($this->question->id))->toBeNull();
    $response->assertRedirect('/questions');
});

test('存在しないidを指定した場合404を返す', function () {
    $latestQuestion = Question::orderBy('id', 'desc')->first();
    $nonExistingId = $latestQuestion->id + 1;

    $response = $this->delete("/questions/{$nonExistingId}");

    $response->assertNotFound();
});

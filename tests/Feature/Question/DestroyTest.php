<?php

use App\Models\Question;

beforeEach(function() {
    $this->question = Question::factory()->create();
});

test('削除が成功すると/questionsにリダイレクトする',function() {
    $response = $this->delete("/questions/{$this->question->id}");

    expect(Question::find($this->question->id))->toBeNull();
    $response->assertRedirect('/questions');
});

test('存在しないidを指定した場合404を返す',function() {
    $latest_question = Question::orderBy('id','desc')->first();
    $non_existing_id = $latest_question->id + 1;

    $response = $this->delete("/questions/{$non_existing_id}");

    $response->assertNotFound();
});
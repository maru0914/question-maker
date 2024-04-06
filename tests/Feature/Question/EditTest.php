<?php

use App\Models\Question;

beforeEach(function () {
    $this->question = Question::factory()->create();
});

test('保存されている内容を閲覧できる', function () {
    $this->get("/questions/{$this->question->id}/edit")
        ->assertOk()
        ->assertSee($this->question->body)
        ->assertSee($this->question->answer);
});

test('idが存在しない場合、404を返す', function () {
    $latestQuestion = Question::orderBy('id', 'desc')->first();
    $nonExistingId = $latestQuestion->id + 1;

    $this->get("/questions/{$nonExistingId}/edit")
        ->assertNotFound();
});

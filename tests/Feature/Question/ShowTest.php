<?php

use App\Models\Question;

beforeEach(function () {
    $this->question = Question::factory()->create();
});

test('/question/{id}を閲覧できる', function () {
    $response = $this->get("/questions/{$this->question->id}");
    $response->assertOk();
});

test('idが存在しない場合、404を返す', function () {
    $latestQuestion = Question::orderBy('id', 'desc')->first();
    $nonExistingId = $latestQuestion->id + 1;

    $response = $this->get("/questions/{$nonExistingId}");
    $response->assertNotFound();
});

test('詳細ページに現在登録されている内容が表示される', function () {
    $response = $this->get("/questions/{$this->question->id}");
    $response->assertSee($this->question->body);
    $response->assertSee($this->question->answer);
});

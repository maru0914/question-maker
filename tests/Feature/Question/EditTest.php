<?php

use App\Models\Question;

beforeEach(function () {
    $this->question = Question::factory()->create();
});

test('/question/{id}/editを閲覧できる', function () {
    $response = $this->get("/questions/{$this->question->id}/edit");
    $response->assertOk();
});

test('idが存在しない場合、404を返す', function () {
    $latest_question = Question::orderBy('id', 'desc')->first();
    $non_existing_id = $latest_question->id + 1;

    $response = $this->get("/questions/{$non_existing_id}/edit");
    $response->assertNotFound();
});

test('編集ページに現在登録されている内容が表示される', function () {
    $response = $this->get("/questions/{$this->question->id}/edit");
    $response->assertSee($this->question->body);
    $response->assertSee($this->question->answer);
});

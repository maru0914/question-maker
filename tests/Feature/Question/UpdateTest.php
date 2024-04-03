<?php

use App\Models\Question;

beforeEach(function () {
    $this->question = Question::factory()->create();
});

test('更新が成功した場合/questionsにリダイレクトする', function () {
    $requestData = [
        'body' => '１＋１は？',
        'answer' => '田んぼの田',
    ];

    $response = $this->put("/questions/{$this->question->id}", $requestData);

    $this->question->refresh();
    expect($this->question->body)->toBe($requestData['body']);
    expect($this->question->answer)->toBe($requestData['answer']);

    $response->assertRedirect('/questions');
});

test('更新が失敗した場合元のページに戻る', function () {
    $response = $this->put("/questions/{$this->question->id}", []);
    // 現在は/にリダイレクトしている
    $response->assertRedirect('/');
})->todo();

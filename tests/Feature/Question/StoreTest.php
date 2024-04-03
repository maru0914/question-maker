<?php

use App\Models\Question;

beforeEach(function () {
    $this->request_data = [
        'body' => '問題を登録する',
        'answer' => '答え',
    ];
});

test('問題を登録できる', function () {
    $this->post('/questions', $this->request_data);

    $question = Question::where('id', 1)->get()->first();
    expect($question->body)->toBe($this->request_data['body']);
    expect($question->answer)->toBe($this->request_data['answer']);
});

test('問題の登録が成功すると/questionsにリダイレクトする', function () {
    $response = $this->post('/questions', $this->request_data);

    $response->assertRedirect('/questions');
});

test('問題の登録が失敗すると/questions/createにリダイレクトする', function () {
    $response = $this->post('/questions', []);

    $response->assertRedirect('/questions/create');
})->todo();

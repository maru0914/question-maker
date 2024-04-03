<?php

beforeEach(function () {
    $this->requestData = [
        'body' => '問題を登録する',
        'answer' => '答え',
    ];
});

test('問題を登録できる', function () {
    $this->post('/questions', $this->requestData);

    $this->assertDatabaseHas('questions', $this->requestData);
});

test('問題の登録が成功すると/questionsにリダイレクトする', function () {
    $response = $this->post('/questions', $this->requestData);

    $response->assertRedirect('/questions');
});

test('問題の登録が失敗すると/questions/createにリダイレクトする', function () {
    $response = $this->post('/questions', []);

    $response->assertRedirect('/questions/create');
})->todo();

<?php

beforeEach(function () {
    $this->requestData = [
        'body' => '問題を登録する',
        'answer' => '答え',
    ];
});

test('問題を登録できる', function () {
    $this->post('/questions', $this->requestData)
        ->assertRedirect('/questions');
    $this->assertDatabaseHas('questions', $this->requestData);
});

test('問題の登録が失敗すると/questions/createにリダイレクトする', function () {
    $this->from('/questions/create')
        ->post('/questions', [])
        ->assertRedirect('/questions/create');
});

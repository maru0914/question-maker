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

test('登録が失敗した場合元のページに戻る', function () {
    $this->from('/questions/create')
        ->post('/questions', [])
        ->assertRedirect('/questions/create');
});

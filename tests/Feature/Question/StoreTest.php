<?php

use App\Models\User;

beforeEach(function () {
    $this->requestData = [
        'body' => '問題を登録する',
        'answer' => '答え',
    ];
    $this->user = User::factory()->create();
});

test('問題を登録できる', function () {
    $this->actingAs($this->user)
        ->post('/questions', $this->requestData)
        ->assertRedirect('/questions');
    $this->assertDatabaseHas('questions', $this->requestData);
});

test('登録が失敗した場合元のページに戻る', function () {
    $this->actingAs($this->user)
        ->from('/questions/create')
        ->post('/questions', [])
        ->assertRedirect('/questions/create');
});

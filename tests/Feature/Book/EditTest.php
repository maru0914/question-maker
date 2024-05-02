<?php

use App\Models\Question;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->question = Question::factory()->for($this->user)->create();
});

test('保存されている内容を閲覧できる', function () {
    $this->actingAs($this->user)
        ->get("/questions/{$this->question->id}/edit")
        ->assertOk()
        ->assertSee($this->question->body)
        ->assertSee($this->question->answer);
});

test('他ユーザーが作成した問題の編集画面はアクセスできない', function () {
    $questionByOtherUser = Question::factory()->create();

    $this->actingAs($this->user)
        ->get("/questions/{$questionByOtherUser->id}/edit")
        ->assertForbidden();
});

test('idが存在しない場合、404を返す', function () {
    $latestQuestion = Question::orderBy('id', 'desc')->first();
    $nonExistingId = $latestQuestion->id + 1;

    $this->actingAs($this->user)
        ->get("/questions/{$nonExistingId}/edit")
        ->assertNotFound();
});

test('ログインしていない場合ログインページにリダイレクト', function () {
    $this->get("/questions/{$this->question->id}/edit")
        ->assertRedirect('/login');
});

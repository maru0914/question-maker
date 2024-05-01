<?php

use App\Models\Question;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->question = Question::factory()->for($this->user)->create();
});

test('問題を削除できる', function () {
    $this->actingAs($this->user)
        ->delete("/questions/{$this->question->id}")
        ->assertRedirect('/questions');

    $this->assertDatabaseMissing('questions', [
        'id' => $this->question->id,
    ]);
});

test('他ユーザーが作成した問題は削除できない', function () {
    $questionByOtherUser = Question::factory()->create();

    $this->actingAs($this->user)
        ->delete("/questions/{$questionByOtherUser->id}")
        ->assertForbidden();

    $this->assertDatabaseHas('questions', [
        'id' => $questionByOtherUser->id,
    ]);
});

test('存在しないidを指定した場合404を返す', function () {
    $latestQuestion = Question::orderBy('id', 'desc')->first();
    $nonExistingId = $latestQuestion->id + 1;

    $this->actingAs($this->user)
        ->delete("/questions/{$nonExistingId}")
        ->assertNotFound();
});

test('ログインしていない場合ログインページにリダイレクト', function () {
    $this->delete("/questions/{$this->question->id}")
        ->assertRedirect('/login');
});

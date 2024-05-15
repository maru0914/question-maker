<?php

use App\Http\Resources\QuestionResource;
use App\Models\Question;

test('問題が登録されていない場合リストが表示されない', function () {
    $this->get('/questions')
        ->assertOK()
        ->assertDontSee('編集');
});

test('questionsがコンポーネントに渡される', function () {
    $questions = Question::factory(3)->create();

    $questions->load('user');

    $this->get('/questions')
        ->assertHasPaginatedResource('questions', QuestionResource::collection($questions->reverse()));
});

test('クエリパラメータpageが数値以外の場合1ページ目の内容が表示される', function () {
    $question = Question::factory()->create();

    $this->get('/questions?page=abc')
        ->assertOK()
        ->assertSee($question->body);
});

test('作成の新しい順に問題が表示される', function () {
    $question1 = Question::factory()->create();
    $question2 = Question::factory()->create();

    $this->get('/questions')
        ->assertOK()
        ->assertSeeInOrder([$question2->body, $question1->body]);
});

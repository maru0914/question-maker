<?php

use App\Models\Question;

test('/にアクセスすると/questionsにリダイレクトする', function () {
    $this->get('/')
        ->assertRedirect('/questions');
});

test('問題が登録されていない場合リストが表示されない', function () {
    $this->get('/questions')
        ->assertOK()
        ->assertDontSee('編集');
});

test('問題が登録されている場合リストが表示される', function () {
    $question = Question::factory()->create();

    $this->get('/questions')
        ->assertOK()
        ->assertViewHas('questions', function ($questions) {
            return count($questions) === 1;
        })
        ->assertSee($question->body);
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

describe('ページネーションのテスト', function () {
    test('登録されている問題が20件以下の場合ページネーションが表示されない', function () {
        Question::factory()->count(20)->create();

        $this->get('/questions')
            ->assertOK()
            ->assertViewHas('questions', function ($questions) {
                return count($questions) === 20;
            })
            ->assertDontSee('/questions?page=');
    });

    test('登録されている問題が21件以上の場合ページネーションが表示される', function () {
        Question::factory()->count(21)->create();

        $this->get('/questions')
            ->assertOK()
            ->assertViewHas('questions', function ($questions) {
                return count($questions) === 20;
            })
            ->assertSee('/questions?page=2');
    });

    test('2ページ目以降にいる場合前のページへのリンクが表示される', function () {
        Question::factory()->count(21)->create();

        $this->get('/questions?page=2')
            ->assertOK()
            ->assertSee('/questions?page=1');
    });

    test('存在しないページ数にアクセスした場合も前のページへのリンクが表示される', function () {
        $this->get('/questions?page=2')
            ->assertOk()
            ->assertSee('/questions?page=1');
    });
});

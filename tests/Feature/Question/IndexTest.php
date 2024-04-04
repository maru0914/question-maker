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
        ->assertSee($question->body)
        ->assertSee('編集')
        ->assertSee('削除');
});

test('クエリパラメータpageが数値以外の場合1ページ目の内容が表示される', function () {
    $question = Question::factory()->create();

    $this->get('/questions?page=abc')
        ->assertOK()
        ->assertSee($question->body);
});

describe('ページネーションのテスト', function () {
    function makeQuestionData(int $cnt)
    {
        for ($i = 0; $i < $cnt; $i++) {
            Question::factory()->create();
        }
    }

    test('登録されている問題が20件以下の場合ページネーションが表示されない', function () {
        $this->get('/questions')
            ->assertOK()
            ->assertDontSee('/questions?page=');
    });

    test('登録されている問題が21件以上の場合ページネーションが表示される', function () {
        makeQuestionData(21);

        $this->get('/questions')
            ->assertOK()
            ->assertSee('/questions?page=2');
    });

    test('2ページ目以降にいる場合前のページへのリンクが表示される', function () {
        makeQuestionData(21);

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

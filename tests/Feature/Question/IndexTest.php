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

test('問題が20件以上あった場合ページネーションする', function () {
    // 要実装
})->todo();

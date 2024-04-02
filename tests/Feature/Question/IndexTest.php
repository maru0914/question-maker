<?php

use App\Models\Question;


test('/にアクセスすると/questionsにリダイレクトする',function () {
    $response = $this->get('/');
    $response->assertRedirect('/questions');
});

test('/questionsが表示できる',function () {
    $response = $this->get('/questions');
    $response->assertOK();
});

test('問題が登録されていない場合リストが表示されない',function () {
    $response = $this->get('/questions');
    $response->assertDontSee('編集');
});

test('問題が登録されている場合リストが表示される',function() {
    $question = Question::factory()->create();

    $response = $this->get('/questions');
    $response->assertSee($question->body);
    $response->assertSee('編集');
    $response->assertSee('削除');
});

test('問題が20件以上あった場合ページネーションする',function (){
    // 要実装
})->todo();

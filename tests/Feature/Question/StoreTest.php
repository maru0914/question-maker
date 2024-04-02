<?php

use App\Models\Question;

test('問題を登録できる',function () {
    $request_question = [
        'body' => '問題を登録する',
        'answer' => '答え'
    ];

    $this->post('/questions',$request_question);

    $question = Question::where('id',1)->get()->first();
    expect($question->body)->toBe($request_question['body']);
    expect($question->answer)->toBe($request_question['answer']);
});

test('問題の登録が成功すると/questionsにリダイレクトする', function (){
    $request_question = [
        'body' => '問題を登録する',
        'answer' => '答え'
    ];

    $response = $this->post('/questions',$request_question);

    $response->assertRedirect('/questions');
});

test('問題の登録が失敗すると/にリダイレクトする???', function (){
    $response = $this->post('/questions',[]);

    $response->assertRedirect('/');
});
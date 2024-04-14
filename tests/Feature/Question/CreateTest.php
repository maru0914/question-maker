<?php

use App\Models\User;

test('/questions/createページが表示できる', function () {

    $this->actingAs(User::factory()->create())
        ->get('/questions/create')
        ->assertOk();
});

test('ログインしていない場合ログインページにリダイレクト', function () {

    $this->get('/questions/create')
        ->assertRedirect('/login');
});

<?php

use App\Http\Controllers\BookController;
use App\Models\User;

covers(BookController::class);

test('/books/createページが表示できる', function () {

    $this->actingAs(User::factory()->create())
        ->get('/books/create')
        ->assertOk();
});

test('ログインしていない場合ログインページにリダイレクト', function () {

    $this->get('/books/create')
        ->assertRedirect('/login');
});

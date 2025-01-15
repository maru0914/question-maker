<?php

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('問題集を登録できる', function () {
    Storage::fake('public');

    $requestData = [
        'title' => '問題集のタイトル',
        'description' => '問題集の説明文',
        'image' => UploadedFile::fake()->image('test.jpg'),
    ];

    $this->actingAs($this->user)
        ->post('/books', $requestData)
        ->assertRedirect('/books');

    $this->assertDatabaseHas('books', Arr::except($requestData, ['image']));
    Storage::disk('public')->assertExists(Book::first()->image_path);
});

test('登録が失敗した場合元のページに戻る', function () {
    $this->actingAs($this->user)
        ->from('/books/create')
        ->post('/books', [])
        ->assertRedirect('/books/create');
});

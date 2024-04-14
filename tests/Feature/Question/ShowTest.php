<?php

use App\Models\Question;

beforeEach(function () {
    $this->question = Question::factory()->create();
});

test('登録されている内容を閲覧できる', function () {
    $this->get("/questions/{$this->question->id}")
        ->assertOk()
        ->assertSee($this->question->body)
        ->assertSee($this->question->answer);
});

test('idが存在しない場合、404を返す', function () {
    $latestQuestion = Question::orderBy('id', 'desc')->first();
    $nonExistingId = $latestQuestion->id + 1;

    $this->get("/questions/{$nonExistingId}")
        ->assertNotFound();
});

describe('「前へ」「次へ」リンクのテスト', function () {
    test('表示中の問題より新しい問題がある時、「前へ」リンクが有効になる', function () {
        $newQuestion = Question::factory()->create();
        $this->get("/questions/{$this->question->id}")
            ->assertOk()
            ->assertSee('前へ')
            ->assertSee(route('questions.show', ['question' => $newQuestion->id]));
    });

    test('表示中の問題より新しい問題がない時、「前へ」リンクが無効になる', function () {
        $this->get("/questions/{$this->question->id}")
            ->assertOk()
            ->assertSee('前へ')
            ->assertSee('<span id="previous" aria-disabled="true"', false);
    });

    test('表示中の問題より古い問題がある時、「次へ」リンクが有効になる', function () {
        $newQuestion = Question::factory()->create();
        $this->get("/questions/$newQuestion->id")
            ->assertOk()
            ->assertSee('次へ')
            ->assertSee(route('questions.show', ['question' => $this->question->id]));
    });

    test('表示中の問題より古い問題がない時、「次へ」リンクが無効になる', function () {
        $this->get("/questions/{$this->question->id}")
            ->assertOk()
            ->assertSee('次へ')
            ->assertSee('<span id="next" aria-disabled="true"', false);
    });
});

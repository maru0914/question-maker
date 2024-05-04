<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('question.index', [
            'questions' => Question::latest('id')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('question.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'body' => 'required',
            'answer' => 'required',
        ]);

        $parentBook = Book::first() ?? Book::factory()->create(); // TODO: bookをユーザーが指定するようにする

        Question::create([
            ...$data,
            'user_id' => auth()->id(),
            'book_id' => $parentBook->id,
            'default_order' => ($parentBook->questions->max('default_order') ?? 0) + 1,
        ]);

        return redirect()->route('questions.index');
    }

    public function show(Question $question): View
    {
        return view('question.show', [
            'question' => $question,
            'previous' => Question::after($question)->oldest('id')->first(),
            'next' => Question::before($question)->latest('id')->first(),
        ]);
    }

    public function edit(Question $question): View
    {
        return view('question.edit', [
            'question' => $question,
        ]);
    }

    public function update(Request $request, Question $question): RedirectResponse
    {
        $question->update($request->validate([
            'body' => 'required',
            'answer' => 'required',
        ]));

        return redirect()->route('questions.index');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return redirect()->route('questions.index');
    }
}

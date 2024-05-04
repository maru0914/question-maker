<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('question.index', [
            'questions' => Question::latest('id')->paginate(20),
        ]);
    }

    public function create(Request $request): View
    {
        return view('question.create', [
            'books' => $request->user()->books,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'body' => 'required',
            'answer' => 'required',
            'book_id' => 'required|exists:books,id',
        ]);

        Question::create([
            ...$data,
            'user_id' => auth()->id(),
            'default_order' => Question::getNextOrder(bookId: $data['book_id']),
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

    public function edit(Request $request, Question $question): View
    {
        return view('question.edit', [
            'question' => $question,
            'books' => $request->user()->books,
        ]);
    }

    public function update(Request $request, Question $question): RedirectResponse
    {
        $question->update($request->validate([
            'body' => 'required',
            'answer' => 'required',
            'book_id' => [
                'required',
                Rule::exists('books', 'id')
                    ->where(fn (Builder $query) => $query->where('user_id', $request->user()->id)),
            ],
        ]));

        return redirect()->route('questions.index');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return redirect()->route('questions.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Question::class);
    }

    public function create(Request $request): Response
    {
        return Inertia::render('Question/Create', [
            'books' => BookResource::collection($request->user()->books),
            'selected_book_id' => (int) $request->query('book_id'),
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

        return redirect()->route('questions.create');
    }

    public function show(Question $question): Response
    {
        $question->load('book');

        $previous = Question::before($question, 'default_order')
            ->where('book_id', $question->book_id)
            ->latest('default_order')
            ->first();
        $next = Question::after($question, 'default_order')
            ->where('book_id', $question->book_id)
            ->oldest('default_order')
            ->first();

        return Inertia::render('Question/Show', [
            'question' => QuestionResource::make($question),
            'questions_count' => $question->book->questions()->count(),
            'previous_link' => $previous ? route('questions.show', [$previous->id]) : null,
            'next_link' => $next ? route('questions.show', [$next->id]) : null,
        ]);
    }

    public function edit(Request $request, Question $question): Response
    {
        return Inertia::render('Question/Edit', [
            'question' => QuestionResource::make($question->load('book')),
            'books' => BookResource::collection($request->user()->books),
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

        return redirect()->route('questions.show', [$question->id]);
    }

    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return redirect()->route('books.show', [$question->book_id]);
    }
}

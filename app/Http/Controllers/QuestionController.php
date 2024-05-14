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
    public function index(): Response
    {
        return Inertia::render('Question/Index', [
            'questions' => QuestionResource::collection(Question::with('user')->latest('id')->paginate(20)),
        ]);
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

        return redirect()->route('questions.index');
    }

    public function show(Question $question): Response
    {
        $previous = Question::after($question)->oldest('id')->first();
        $next = Question::before($question)->latest('id')->first();

        return Inertia::render('Question/Show', [
            'question' => QuestionResource::make($question),
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

        return redirect()->route('questions.index');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return redirect()->route('questions.index');
    }
}

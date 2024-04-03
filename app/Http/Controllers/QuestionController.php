<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('question.index', [
            'questions' => Question::paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('question.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Question::create($request->validate([
            'body' => 'required',
            'answer' => 'required',
        ]));

        return redirect()->route('questions.index');
    }

    public function show(Question $question): View
    {
        return view('question.show', [
            'question' => $question,
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

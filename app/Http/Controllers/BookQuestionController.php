<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Http\Resources\QuestionResource;
use App\Models\Book;
use App\Models\Question;
use Inertia\Inertia;
use Inertia\Response;

class BookQuestionController extends Controller
{
    public function show(Book $book, Question $question): Response
    {
        $previous = Question::before($question, 'default_order')->where('book_id', $book->id)->latest('default_order')->first();
        $next = Question::after($question, 'default_order')->where('book_id', $book->id)->oldest('default_order')->first();

        return Inertia::render('Question/Show', [
            'book' => BookResource::make($book),
            'question' => QuestionResource::make($question),
            'question_count' => $book->questions()->count(),
            'previous_link' => $previous ? route('books.questions.show', [$book->id, $previous->id]) : null,
            'next_link' => $next ? route('books.questions.show', [$book->id, $next->id]) : null,
        ]);
    }
}

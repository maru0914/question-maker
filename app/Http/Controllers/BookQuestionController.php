<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Question;
use Illuminate\View\View;

class BookQuestionController extends Controller
{
    public function show(Book $book, Question $question): View
    {
        $previous = Question::before($question, 'default_order')->where('book_id', $book->id)->latest('default_order')->first();
        $next = Question::after($question, 'default_order')->where('book_id', $book->id)->oldest('default_order')->first();

        return view('question.show', [
            'book' => $book,
            'question' => $question,
            'previous_link' => $previous ? route('books.questions.show', [$book->id, $previous->id]) : null,
            'next_link' => $next ? route('books.questions.show', [$book->id, $next->id]) : null,
        ]);
    }
}

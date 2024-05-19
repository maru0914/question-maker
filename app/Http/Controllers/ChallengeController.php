<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function store(Request $request, Book $book): RedirectResponse
    {
        $data = $request->validate([
            'challenges' => ['required', 'array'],
            'challenges.*.question_id' => ['required', 'exists:questions,id'],
            'challenges.*.is_success' => ['required', 'bool'],
        ]);

        $request->user()->challenges()->createMany($data['challenges']);

        return redirect()->route('books.show', $book);
    }
}

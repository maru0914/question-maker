<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookQuestionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/create', [BookController::class, 'create'])->name('books.create')->middleware('auth');
Route::post('/books', [BookController::class, 'store'])->name('books.store')->middleware('auth');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit')
    ->middleware('auth')
    ->can('update', 'book');
Route::patch('/books/{book}', [BookController::class, 'update'])->name('books.update')
    ->middleware('auth')
    ->can('update', 'book');
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy')
    ->middleware('auth')
    ->can('delete', 'book');

Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create')->middleware('auth');
Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store')->middleware('auth');
Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');
Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit')
    ->middleware('auth')
    ->can('update', 'question');
Route::patch('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update')
    ->middleware('auth')
    ->can('update', 'question');
Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy')
    ->middleware('auth')
    ->can('delete', 'question');

Route::get('/books/{book}/questions/{question}', [BookQuestionController::class, 'show'])->name('books.questions.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

<?php

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

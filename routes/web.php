<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/**
 *  リソース操作
 */
Route::redirect('/', '/books');

Route::middleware('auth')->group(function () {
    Route::resource('books', BookController::class)->except(['index', 'show']);
    Route::resource('questions', QuestionController::class)->except(['index', 'show']);
});

Route::resource('books', BookController::class)->only(['index', 'show']);
Route::get('questions/{question}', [QuestionController::class, 'show'])->name('questions.show');

/**
 *  マイページ
 */
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 *  プロフィール操作
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 *  認証
 */
require __DIR__.'/auth.php';

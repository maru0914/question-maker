<?php

namespace App\Http\Controllers;

use App\Exceptions\StorageException;
use App\Http\Resources\BookResource;
use App\Http\Resources\QuestionResource;
use App\Models\Book;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class BookController extends Controller
{
    public function __construct(protected ImageService $imageService)
    {
        $this->authorizeResource(Book::class);
    }

    public function index(): Response
    {
        return Inertia::render('Book/Index', [
            'books' => BookResource::collection(Book::with('user')->latest('id')->paginate(20)),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Book/Create');
    }

    /**
     * @throws StorageException
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'required|image|max:2048',
        ]);

        $filePath = $this->imageService->upload($request->file('image'));

        Book::create([
            ...$data,
            'user_id' => auth()->id(),
            'image_path' => $filePath,
        ]);

        return redirect()->route('books.index');
    }

    public function show(Book $book): Response
    {
        $book->load([
            'questions.latestChallenge',
            'questions' => function (HasMany $query) {
                $query->orderBy('default_order');
            }]);

        return Inertia::render('Book/Show', [
            'book' => BookResource::make($book),
            'questions' => QuestionResource::collection($book->questions),
        ]);
    }

    public function edit(Book $book): Response
    {
        return Inertia::render('Book/Edit', [
            'book' => BookResource::make($book),
        ]);
    }

    /**
     * @throws StorageException
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $filePath = $this->imageService->upload($request->file('image'));
            $oldImagePath = $book->image_path;
            $book->update([...$data, 'image_path' => $filePath]);
            Storage::disk('public')->delete($oldImagePath);
        }

        $book->update($data);

        return redirect()->route('books.index');
    }

    /**
     * @throws StorageException
     */
    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        if ($book->image_path) {
            $this->imageService->delete($book->image_path);
        }

        return redirect()->route('books.index');
    }
}

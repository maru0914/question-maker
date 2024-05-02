<?php

namespace App\Http\Controllers;

use App\Exceptions\StorageException;
use App\Models\Book;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookController extends Controller
{
    public function __construct(protected ImageService $imageService)
    {
    }

    public function index(): View
    {
        return view('book.index', [
            'books' => Book::latest('id')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('book.create');
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

    public function show(Book $book): View
    {
        return view('book.show', [
            'book' => $book,
        ]);
    }

    public function edit(Book $book): View
    {
        return view('book.edit', [
            'book' => $book,
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
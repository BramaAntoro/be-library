<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Services\BookService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    protected BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index()
    {
        try {

            $books = $this->bookService->getAllBooks();

            return response()->json([
                "message" => 'data books',
                'data' => $books
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "failed to retrieve author data",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $credentials = $request->validate([
                'title' => 'required|string|max:255',
                'author_id' => 'required|exists:authors,id',
                'isbn' => 'required|size:13|unique:books,isbn',
                'published_year' => 'required|date',
                'description' => 'required|string',
                'total_copies' => 'required|integer|min:0',
                'total_borrowed' => 'nullable|integer|min:0',
                'cover_image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp'
            ]);

            $imagePath = $request->file('cover_image_url')->store('cover_images', 'public');

            $credentials['cover_image_url'] = $imagePath;

            $book = $this->bookService->createBook($credentials);

            return response()->json([
                'message' => "Book $book->name has been created",
                'data' => $book
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'meseage' => 'failed create book',
                'errors' => $e->errors()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $credentials = $request->validate([
                'title' => 'string|max:255',
                'author_id' => 'exists:authors,id',
                'isbn' => 'size:13|unique:books,isbn',
                'published_year' => 'date',
                'description' => 'string',
                'total_copies' => 'integer|min:0',
                'total_borrowed' => 'integer|min:0',
                'cover_image_url' => 'image|mimes:jpeg,png,jpg,gif,svg,webp'
            ]);

            $file = $request->file('cover_image_url');

            $updatedBook = $this->bookService->updateBook($id, $credentials, $file);

            return response()->json([
                "message" => "book $updatedBook->title successfully updated",
                'data' => $updatedBook
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'failed to update a book',
                'error' => $e->errors()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $this->bookService->deleteBook($id);

            return response()->json([
                'message' => 'Book successfully deleted'
            ], 200);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Book not found'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'book failed to delete',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthorController extends Controller
{
    protected AuthorService $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index(Request $request)
    {
        try {

            $search = $request->query('search');

            if ($search) {

                $authors = $this->authorService->searchAuthor($search);

                return response()->json([
                    "message" => "Search result",
                    'data' => $authors
                ], '200');

            }

            $authors = $this->authorService->getAllAuthors();

            return response()->json([
                'message' => 'Data authors',
                'data' => $authors
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'failed to retrieve author data',
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
                'name' => 'required|string|',
                'bio' => 'string'
            ]);

            $author = $this->authorService->createAuthor($credentials);

            return response()->json([
                'message' => "Author with name $author->name has been created",
                'data' => $author
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                "message" => "failed to create a author",
                "errors" => $e->errors()
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
                'name' => 'string',
                'bio' => 'string'
            ]);

            $updatedAuthor = $this->authorService->updateAuthor($id, $credentials);

            return response()->json([
                "message" => "Author $updatedAuthor->name successfully updated",
                "data" => $updatedAuthor
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'failed to update a author',
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

            $this->authorService->deleteAuthor($id);

             return response()->json([
                'message' => 'Author successfully deleted'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Author not found'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Auhtor failed to delete',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

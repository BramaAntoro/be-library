<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        try {

            $categories = $this->categoryService->getAllCategories();

            return response()->json([
                "message" => 'data categories',
                'data' => $categories
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'failed to retrieve category data',
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
                'name' => 'required|string|unique:categories,name'
            ]);

            $category = $this->categoryService->createCategory($credentials);

            return response()->json([
                'message' => "Category with name $category->name has been created",
                'data' => $category
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Failed create category',
                'error' => $e->getMessage()
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
                'name' => 'string'
            ]);

            $Updatedcategory = $this->categoryService->updateCategory($id, $credentials);

            return response()->json([
                "message" => "Category $Updatedcategory->name successfully updated",
                "data" => $Updatedcategory
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Failed update category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $this->categoryService->deleteCategory($id);

            return response()->json([
                'message' => 'Category successfully deleted'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Category not found'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Category failed to delete',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

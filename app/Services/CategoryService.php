<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function createCategory($credentials)
    {
        return Category::query()->create([
            'name' => $credentials['name']
        ]);
    }

    public function getAllCategories()
    {
        return Category::query()->get();
    }

    public function updateCategory($id, array $data)
    {
        $category = Category::query()->findOrFail($id);

        $category->update($data);

        return $category;
    }

    public function deleteCategory($id)
    {
        $category = Category::query()->findOrFail($id);
        $category->delete();
        return true;
    }
}
<?php

namespace App\Services;

use App\Models\Author;

class AuthorService
{
    public function createAuthor($credentials)
    {
        return Author::query()->create([
            'name' => $credentials['name'],
            'bio' => $credentials['bio'] ?? null
        ]);
    }

    public function getAllAuthors()
    {
        return Author::query()->get();
    }

    public function searchAuthor($keyword)
    {
        return Author::query()->where('name', 'like', "%$keyword%")->get();
    }

    public function updateAuthor($id, array $data)
    {
        $author = Author::query()->findOrFail($id);

        $author->update($data);
        return $author;
    }

    public function deleteAuthor($id)
    {
        $author = Author::query()->findOrFail($id);
        $author->delete();
        return true;
    }

}
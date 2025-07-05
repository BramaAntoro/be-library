<?php

namespace App\Services;

use App\Models\Books;
use Illuminate\Support\Facades\Storage;

class BookService
{
    public function createBook($credentials)
    {
        return Books::query()->create([
            'title' => $credentials['title'],
            'author_id' => $credentials['author_id'],
            'isbn' => $credentials['isbn'],
            'published_year' => $credentials['published_year'],
            'description' => $credentials['description'],
            'total_copies' => $credentials['total_copies'],
            'total_borrowed' => $credentials['total_borrowed'] ?? 0,
            'cover_image_url' => $credentials['cover_image_url']
        ]);
    }

    public function getAllBooks()
    {
        return Books::query()->get();
    }

    public function updateBook($id, array $data, $file = null)
    {
        $book = Books::query()->findOrFail($id);

        if ($file) {
            if ($book->cover_image_url && Storage::disk('public')->exists($book->cover_image_url)) {
                Storage::disk('public')->delete($book->cover_image_url);
            }

            $imagePath = $file->store('cover_images', 'public');
            $data['cover_image_url'] = $imagePath;
        } else {
            $data['cover_image_url'] = $book->cover_image_url;
        }


        if (!empty($data)) {
            $book->update($data);
        }
        return $book;
    }

    public function deleteBook($id)
    {
        $book = Books::query()->findOrFail($id);
        $book->delete();
        return true;
    }
}
<?php

namespace App\Services;

use App\Models\Author;

class AuthorService
{
    public function createAuthor($credentials)
    {
        return Author::query()->create([
            'name' => $credentials['name'],
            'bio' => $credentials['bio']
        ]);   
    }
}
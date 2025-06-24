<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $fillable = [
        'title',
        'author_id',
        'isbn',
        'published_year',
        'description',
        'total_copies',
        'total_borrowed',
        'stock',
        'cover_image_url',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category', 'book_id', 'category_id');
    }

    public function loans()
    {
        return $this->hasMany(Loans::class, 'book_id', 'id');
    }
}

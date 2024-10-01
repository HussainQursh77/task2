<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'author',
        'published_at',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeByTitle($query, $title)
    {
        if ($title) {
            $query->where('title', $title);
        }
        return $query;
    }


    public function scopeByAuthor($query, $author)
    {
        if ($author) {
            $query->where('author', $author);
        }
        return $query;
    }

    public function scopeByCategory($query, $categoryName)
    {
        if ($categoryName) {
            $query->whereHas('category', function ($q) use ($categoryName) {
                $q->where('name', $categoryName);
            });
        }
        return $query;
    }
}

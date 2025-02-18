<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function scopeByName($query, $name)
    {
        if ($name) {
            $query->where('name', $name);
        }
        return $query;
    }
}

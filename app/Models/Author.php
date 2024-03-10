<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class Author extends Model
{
    use HasFactory, HasTimestamps;

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_author');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class Article extends Model
{
    use HasFactory, HasTimestamps;

    protected $fillable = ['title', 'content']; 

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'article_author');
    }
}
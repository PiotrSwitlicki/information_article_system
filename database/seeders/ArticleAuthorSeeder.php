<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Author;

class ArticleAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = Article::all();
        $authors = Author::all();

        foreach ($articles as $article) {
            $article->authors()->attach(
                $authors->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
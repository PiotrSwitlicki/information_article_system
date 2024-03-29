<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Author;
use Illuminate\Support\Facades\DB;

class ArticleService
{
    protected $article; // Model artykułu
    protected $author; // Model autora

    /**
     * Konstruktor klasy ArticleService
     * @param Article $article Model artykułu
     * @param Author $author Model autora
     */

    public function __construct(Article $article, Author $author)
    {
        $this->article = $article;
        $this->author = $author;
    }

    /**
     * Pobiera wszystkie artykuły wraz z autorami.
     * @return \Illuminate\Database\Eloquent\Collection Kolekcja artykułów
     */

    public function getAllArticlesWithAuthors()
    {
        return $this->article->with('authors')->get();
    }

    /**
     * Pobiera wszystkich autorów.
     * @return \Illuminate\Database\Eloquent\Collection Kolekcja autorów
     */

    public function getAllAuthors()
    {
        return $this->author->all();
    }

    /**
     * Tworzy artykuł.
     */

    public function createArticle(array $data)
    {
        // Tworzenie nowego autora, jeśli jest wybrana opcja "new"
        if (isset($data['authors']) && $data['authors'][0] == "new") {
            $author = new Author();
            $author->first_name = $data['new_author_first_name'];
            $author->last_name = $data['new_author_last_name'];
            $author->save();
            $lastInsertedId = $author->id;
        }

        // Walidacja danych artykułu
        $validatedData = validator($data, [
            'title' => 'required|max:255',
            'content' => 'required',
            'authors' => 'required|array',
        ])->validate();

        if (empty($validatedData['title'])) {
            throw new \Exception('Pole tytułu jest wymagane.');
        }

        if (empty($validatedData['content'])) {
            throw new \Exception('Pole treści jest wymagane.');
        }
        // Utworzenie artykułu
        $article = new Article();
        $article->title = $validatedData['title'];
        $article->content = $validatedData['content'];
        $article->save();
        // Przypisanie autorów do artykułu
        if (isset($lastInsertedId)) {
            // Dodanie powiązania artykułu z nowym autorem
            DB::table('article_author')->insert([
                'article_id' => $article->id,
                'author_id' => $lastInsertedId
            ]);
        }
    }

    //aktualizuje artykuły
    public function updateArticle(array $data, $id)
    {
        // Walidacja danych artykułu
        $validatedData = validator($data, [
            'title' => 'nullable',
            'content' => 'nullable', 
        ])->validate();

        if (empty($validatedData['title'])) {
            return ['error' => 'Pole tytułu jest wymagane.'];
        }

        if (empty($validatedData['content'])) {
            return ['error' => 'Pole treści jest wymagane.'];
        }
        // Aktualizacja artykułu
        $article = Article::findOrFail($id);        
        $article->title = $validatedData['title'];
        $article->content = $validatedData['content'];
        $article->save();
        // Przypisanie autorów do artykułu
        if (isset($data['authors'])) {
            $article->authors()->sync($data['authors']);
        }

        // Zwrócenie sukcesu
        return ['success' => 'Artykuł został zaktualizowany.'];
    }

    /**
     * Pobiera artykuł o podanym ID.
     * @param int $id ID artykułu
     * @return \App\Models\Article Artykuł
     */

    public function getArticle($id)
    {
        return $this->article->findOrFail($id);
    }

    /**
     * Pobiera artykuły napisane przez danego autora.
     * @param int $authorId ID autora
     * @return \Illuminate\Database\Eloquent\Collection Kolekcja artykułów
     */

    public function getArticlesByAuthor($authorId)
    {
        return $this->article->whereHas('authors', function ($query) use ($authorId) {
            $query->where('authors.id', $authorId);
        })->get();
    }

    /**
     * Pobiera top autorów z ostatniego tygodnia.
     * @return \Illuminate\Database\Eloquent\Collection Kolekcja autorów
     */

    public function getTopAuthorsLastWeek()
    {
        return $this->author->withCount('articles')
            ->whereHas('articles', function ($query) {
                $query->whereBetween('articles.created_at', [now()->startOfWeek(), now()]);
            })
            ->orderByDesc('articles_count')
            ->limit(3)
            ->get();
    }
}
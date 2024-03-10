<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Author;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ArticleController extends Controller
{

    public function index()
    {
        $articles = Article::with('authors')->get();
        return view('articles', compact('articles'));
    }
    
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function create()
    {
        $authors = Author::all();
        return view('articles.create', ['authors' => $authors]);
    }

    public function store(Request $request)
    {

        //dd($request);
        $lastInsertedId = null;

        if($request->authors[0] == "new")
        {
            $author = new Author();
            $author->first_name = $request->new_author_first_name;
            $author->last_name = $request->new_author_last_name;
            $author->save();
            $lastInsertedId = $author->id;
        }

        // Walidacja danych wejściowych
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'authors' => 'required|array',
        ]);

        // Utwórzenie nowego artykułu
        $article = new Article();
        $article->title = $request->title;
        $article->content = $request->content;
        $article->save();

        // Sprawdzenie, czy wybrano autorów i przypisz ich do artykułu
        if ($lastInsertedId == null) {
            if ($request->has('authors')) {
                $article->authors()->attach($request->input('authors'));
            }
        }

        if (isset($lastInsertedId)) {
            DB::table('article_author')->insert([
                'article_id' => $article->id,
                'author_id' => $lastInsertedId
            ]);            
        }

        // Przekierowywanie użytkownika do zapisania artykułu
        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->save();

        return redirect()->route('articles.index')->with('success', 'Zmiany zostały zapisane.');
    }

    // Metoda do pobierania artykułu według identyfikatora
    public function getArticle($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    // Metoda do pobierania wszystkich artykułów danego autora
    public function getArticlesByAuthor($authorId)
    {
        $articles = Article::whereHas('authors', function ($query) use ($authorId) {
            $query->where('authors.id', $authorId);
        })->get();
        return response()->json($articles);
    }

    // Metoda do pobierania 3 najlepszych autorów z ostatniego tygodnia
    public function getTopAuthorsLastWeek()
    {
        $topAuthors = Author::withCount('articles')
            ->whereHas('articles', function ($query) {
                $query->whereBetween('articles.created_at', [now()->startOfWeek(), now()]);
            })
            ->orderByDesc('articles_count')
            ->limit(3)
            ->get();

        return response()->json($topAuthors);
    }
}
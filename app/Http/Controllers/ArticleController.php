<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Author;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ArticleController extends Controller
{
    protected $article;
    protected $author;

    public function __construct(Article $article, Author $author)
    {
        $this->article = $article;
        $this->author = $author;
    }

    public function index()
    {
        $articles = $this->article->with('authors')->get();
        return view('articles', compact('articles'));
    }
    
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function create()
    {
        $authors = $this->author->all();
        return view('articles.create', ['authors' => $authors]);
    }

    public function store(Request $request)
    {
        $lastInsertedId = null;

        if ($request->has('authors') && $request->authors[0] == "new") {
            $author = new Author();
            $author->first_name = $request->new_author_first_name;
            $author->last_name = $request->new_author_last_name;
            $author->save();
            $lastInsertedId = $author->id;
        }

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'authors' => 'required|array',
        ]);

        if (empty($validatedData['title'])) {
            return redirect()->back()->withErrors(['title' => 'Pole tytułu jest wymagane.'])->withInput();
        }

        if (empty($validatedData['content'])) {
            return redirect()->back()->withErrors(['content' => 'Pole treści jest wymagane.'])->withInput();
        }

        $article = new Article();
        $article->title = $validatedData['title'];
        $article->content = $validatedData['content'];
        $article->save();

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

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $article = $this->article->findOrFail($id);
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->save();

        return redirect()->route('articles.index')->with('success', 'Changes have been saved.');
    }

    public function getArticle($id)
    {
        $article = $this->article->findOrFail($id);
        return response()->json($article);
    }

    public function getArticlesByAuthor($authorId)
    {
        $articles = $this->article->whereHas('authors', function ($query) use ($authorId) {
            $query->where('authors.id', $authorId);
        })->get();
        return response()->json($articles);
    }

    public function getTopAuthorsLastWeek()
    {
        $topAuthors = $this->author->withCount('articles')
            ->whereHas('articles', function ($query) {
                $query->whereBetween('articles.created_at', [now()->startOfWeek(), now()]);
            })
            ->orderByDesc('articles_count')
            ->limit(3)
            ->get();

        return response()->json($topAuthors);
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArticleService; // Importowanie zależności ArticleService
use App\Models\Article;
use App\Models\Author;
use Illuminate\View\View;

class ArticleController extends Controller
{
    protected $articleService;   // Wstrzykiwanie zależności dla ArticleService

    /**
     * Konstruktor wstrzykujący ArticleService do kontrolera
     *
     * @param ArticleService $articleService Instancja ArticleService
     */

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Wyświetlanie listy artykułów.
     *
     * @return \Illuminate\View\View Widok artykułów
     */

    public function index()
    {
        // Pobranie wszystkich artykułów wraz z autorami za pomocą ArticleService
        $articles = $this->articleService->getAllArticlesWithAuthors(); 
        return view('articles', compact('articles'));
    }

    /**
     * Wyświetlanie określonego artykułu.
     *
     * @param  int  $id ID artykułu
     * @return \Illuminate\View\View Widok szczegółowy artykułu
     */
    
    public function show($id)
    {
        // Pobranie artykułu po ID za pomocą ArticleService
        $article = $this->articleService->getArticleById($id);
        return view('articles.show', compact('article'));
    }
    /**
     * Wyświetlanie formularza tworzenia nowego artykułu.
     *
     * @return \Illuminate\View\View Widok formularza tworzenia artykułu
     */
    public function create()
    {
        // Pobranie wszystkich autorów dla formularza tworzenia artykułu
        $authors = $this->articleService->getAllAuthors();
        return view('articles.create', ['authors' => $authors]);
    }
    /**
     * Zapis nowego artykułu do bazy danych.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse Przekierowanie na stronę główną z wiadomością o sukcesie
     */
    public function store(Request $request)
    {
        // Utworzenie artykułu za pomocą ArticleService
        $this->articleService->createOrUpdateArticle($request->all());

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }
    //Edycja artykułu
    public function edit($id)
    {
        $article = $this->articleService->getArticleById($id);
        return view('articles.edit', compact('article'));
    }
    //Aktualizac danych w bazie
    public function update(Request $request, $id)
    {
        $this->articleService->createOrUpdateArticle($request->all(), $id);

        return redirect()->route('articles.index')->with('success', 'Changes have been saved.');
    }
    //Endpoint API
    public function getArticlesByAuthor($authorId)
    {
        $articles = $this->articleService->getArticlesByAuthor($authorId);
        return response()->json($articles);
    }
    //Endpoint API
    public function getTopAuthorsLastWeek()
    {
        $topAuthors = $this->articleService->getTopAuthorsLastWeek();
        return response()->json($topAuthors);
    }
    //Endpoint API 
    public function getArticle($id)
    {
        $article = $this->articleService->getArticle($id);
        return response()->json($article);
    }

}
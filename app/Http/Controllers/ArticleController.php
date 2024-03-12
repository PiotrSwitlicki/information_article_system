<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArticleService; 
use App\Models\Article;
use App\Models\Author;
use Illuminate\View\View;

class ArticleController extends Controller
{
    protected $articleService;   

    /**
     * Konstruktor wstrzykujący ArticleService do kontrolera
     * @param ArticleService $articleService Instancja ArticleService
     */

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Wyświetlanie listy artykułów.
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
     * @param  int  $id ID artykułu
     * @return \Illuminate\View\View Widok szczegółowy artykułu
     */
    
    public function show($id)
    {
        // Pobranie artykułu po ID za pomocą ArticleService
        $article = $this->articleService->getArticle($id);
        return view('articles.show', compact('article'));
    }
    /**
     * Wyświetlanie formularza tworzenia nowego artykułu.
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse Przekierowanie na stronę główną z wiadomością o sukcesie
     */
    public function store(Request $request)
    {   
        // Inicjacja zmiennej $existingAuthor z wartością null
        $existingAuthor = null;

        // Sprawdzanie dla nowego autora czy nie ma go już w bazie
        if(isset($request->authors[0]))
        {
            $existingAuthor = Author::where('first_name', $request->new_author_first_name)
                                    ->where('last_name', $request->new_author_last_name)
                                    ->first();
        }

        // Wyświetlenie komunikatu, że autor jest już w bazie
        if ($existingAuthor != null) {
            return redirect()->route('articles.create')->with('error', 'Autor o podanej kombinacji imienia i nazwiska już istnieje.');
        }
        
        // Wywołanie metody createArticle z ArticleService
        $this->articleService->createArticle($request->all());
        
        // Wyświetlenie komunikatu o sukcesie
        return redirect()->route('articles.index')->with('success', 'Artykuł utworzony z sukcesem.');
    }
    //Aktualizac danych w bazie
    public function update(Request $request, $id)
    {
        $result = $this->articleService->updateArticle($request->all(), $id);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->route('articles.index')->with('success', $result['success']);
    }
    //Edycja artykułu
    public function edit($id)
    {
        $article = $this->articleService->getArticle($id);
        return view('articles.edit', compact('article'));
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
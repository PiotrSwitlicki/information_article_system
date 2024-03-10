<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;


Route::get('/', function () {
    return redirect()->route('articles.index');
});

//Routingi pogrupowałem dla lepszej czytelności 
Route::prefix('articles')->group(function () {
    Route::get('/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/{article}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::post('/', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/API/{authorId}', [ArticleController::class, 'getArticlesByAuthor']);
});

Route::prefix('authors')->group(function () {
	Route::get('/', [AuthorController::class, 'getAllAuthors']);
	Route::get('/create', [AuthorController::class, 'create'])->name('authors.create');
	Route::post('/', [AuthorController::class, 'store'])->name('authors.store');
});

Route::get('/article/{id}', [ArticleController::class, 'getArticle']);
Route::get('/top-authors', [ArticleController::class, 'getTopAuthorsLastWeek']);
Route::post('/author', [AuthorController::class, 'addAuthor']);

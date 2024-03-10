<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;
use App\Models\Author;

class ArticleApiTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_returns_single_article()
    {
        error_log('Starting test it_returns_single_article');
        $article = Article::factory()->create();
        error_log('Article created with ID: ' . $article->id);
        //dd($article['id']);
        $response = $this->get("/article/$article->id");
        error_log('Response received: ' . $response->getContent());
        $response->assertStatus(200)
            ->assertJson([
                'id' => $article->id,              
            ]);
    }

    /** @test */
    public function it_returns_articles_by_author()
    {
        $author = Author::factory()->create();
        $article = Article::factory()->create();
        $author->articles()->attach($article);

        $response = $this->get("/articles/API/{$author->id}");

        $response->assertStatus(200)
            ->assertJsonCount(1); 
    }

    /** @test */
    public function it_returns_top_authors_last_week()
    {
        $response = $this->get('/top-authors');
        $response->assertStatus(200)
            ->assertJsonCount(3); 
    }

    public function tearDown(): void
    {
        // Czyszczenie bazy danych po każdym teście
        parent::tearDown();
    }
}
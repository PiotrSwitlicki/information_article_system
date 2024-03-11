<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_create_an_article()
    {
        $article = Article::factory()->create([
            'title' => 'Test Article',
            'content' => 'This is a test article content.'
        ]);

        $this->assertInstanceOf(Article::class, $article);
        $this->assertEquals('Test Article', $article->title);
        $this->assertEquals('This is a test article content.', $article->content);
    }
}
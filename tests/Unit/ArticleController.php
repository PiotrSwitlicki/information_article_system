<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticleControllerTest extends TestCase
{	
	use DatabaseTransactions;
    /** @test */
    public function it_can_return_all_articles()
    {
        $controller = new ArticleController();
        $request = Request::create('/articles', 'GET');
        $response = $controller->index($request);

        $this->assertEquals(200, $response->status());

    }
}
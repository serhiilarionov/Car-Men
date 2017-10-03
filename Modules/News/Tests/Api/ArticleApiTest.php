<?php namespace Modules\News\Tests\API;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\News\Entities\Article;
use Modules\News\Tests\Traits\MakeArticlesTrait;
use Tests\ApiTestTrait;
use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    use MakeArticlesTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    public function testReadArticles()
    {
        $articles = Article::active()->get();
        $this->json('GET', '/api/v1/news/articles');

        $this->assertApiCheckLenghtWithPaginate($articles->toArray());
    }
    
    public function testReadArticle()
    {
        $article = Article::orderBy('id')->select('id', 'title', 'text', 'source_id', 'source_link', 'image', 'publication_date')->where('verified','=','true')->first()->toArray();
        $article['source_name'] = \Modules\News\Entities\Source::where('id', $article['source_id'])->value('name');
        unset($article['source_id']);
        $this->json('GET', '/api/v1/news/articles/'.$article['id']);

        $this->assertApiResponse($article);
    }
}

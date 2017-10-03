<?php namespace Modules\News\Tests\Repositories;

use Modules\News\Entities\Article;
use Modules\News\Repositories\ArticleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\News\Tests\Traits\MakeArticlesTrait;
use Tests\ApiTestTrait;
use Tests\TestCase;

class ArticleRepositoryTest extends TestCase
{
    use MakeArticlesTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ArticleRepository
     */
    protected $articlesRepo;

    public function setUp()
    {
        parent::setUp();
        $this->articlesRepo = \App::make(ArticleRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateArticles()
    {
        $articles = $this->fakeArticlesData();
        $createdArticles = $this->articlesRepo->create($articles);
        $createdArticles = $createdArticles->toArray();
        $this->assertArrayHasKey('id', $createdArticles);
        $this->assertNotNull($createdArticles['id'], 'Created Articles must have id specified');
        $this->assertNotNull(Article::find($createdArticles['id']), 'Articles with given id must be in DB');
        $this->assertModelData($articles, $createdArticles);
    }

    /**
     * @test read
     */
    public function testReadArticles()
    {
        $articles = $this->makeArticles();
        $dbArticles = $this->articlesRepo->find($articles->id);
        $dbArticles = $dbArticles->toArray();
        $this->assertModelData($articles->toArray(), $dbArticles);
    }

    /**
     * @test update
     */
    public function testUpdateArticles()
    {
        $articles = $this->makeArticles();
        $fakeArticles = $this->fakeArticlesData();
        $updatedArticles = $this->articlesRepo->update($fakeArticles, $articles->id);
        $this->assertModelData($fakeArticles, $updatedArticles->toArray());
        $dbArticles = $this->articlesRepo->find($articles->id);
        $this->assertModelData($fakeArticles, $dbArticles->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteArticles()
    {
        $articles = $this->makeArticles();
        $resp = $this->articlesRepo->delete($articles->id);
        $this->assertTrue($resp);
        $this->assertNull(Article::find($articles->id), 'Articles should not exist in DB');
    }
}

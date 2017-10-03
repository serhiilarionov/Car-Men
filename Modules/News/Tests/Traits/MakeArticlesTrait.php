<?php namespace Modules\News\Tests\Traits;

use Faker\Factory as Faker;
use Modules\News\Entities\Article;
use Modules\News\Repositories\ArticleRepository;

trait MakeArticlesTrait
{
    /**
     * Create fake instance of Articles and save it in database
     *
     * @param array $articlesFields
     * @return Articles
     */
    public function makeArticles($articlesFields = [])
    {
        /** @var ArticleRepository $articlesRepo */
        $articlesRepo = \App::make(ArticleRepository::class);
        $theme = $this->fakeArticlesData($articlesFields);

        return $articlesRepo->create($theme);
    }

    /**
     * Get fake instance of Articles
     *
     * @param array $articlesFields
     * @return Articles
     */
    public function fakeArticles($articlesFields = [])
    {
        return new Article($this->fakeArticlesData($articlesFields));
    }

    /**
     * Get fake data of Articles
     *
     * @param array $articlesFields
     * @return array
     */
    public function fakeArticlesData($articlesFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'title' => $fake->word,
            'text' => $fake->word,
            'source_id' => \Modules\News\Entities\Source::orderBy('id')->first()->value('id'),
            'source_link' => $fake->word,
            'image' => $fake->word,
            'verified' => true,
            'publication_date'=> $fake->date('Y-m-d H:i:s')
        ], $articlesFields);
    }
}

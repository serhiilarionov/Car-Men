<?php namespace Modules\News\Criterias;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;

class LimitOffsetArticlePopularCriteria implements CriteriaInterface
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply criteria in query repository.
     *
     * @param $model
     * @param \Prettus\Repository\Contracts\RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, \Prettus\Repository\Contracts\RepositoryInterface $repository)
    {

        $date = Carbon::now()->subDay($this->request->get('days', 1));

        $limit = $this->request->get('limit', 0);
        $offset = $this->request->get('offset', null);

        $maxLimit = config('catalog.max_limit', 100);
        $defaultLimit = config('catalog.default_limit', 50);

        $limit = $limit == 0 ? $defaultLimit : $limit;
        $limit = $limit > $maxLimit ? $maxLimit : $limit;
        $model = $model
            ->select('*', 'news_articles.id as id')
            ->active()
            ->where('news_articles.publication_date', '>', $date)
            ->has('popular')
            ->join('news_articles_popular', 'news_articles.id', '=', 'news_articles_popular.article_id')
            ->orderBy('total', 'desc')
            ->limit($limit);
        if ($offset && $limit) {
            $model = $model->skip($offset);
        }

        return $model;
    }
}
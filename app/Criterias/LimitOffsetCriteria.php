<?php namespace App\Criterias;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;

class LimitOffsetCriteria implements CriteriaInterface
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
        $limit = $this->request->get('limit', 0);
        $offset = $this->request->get('offset', null);

        $maxLimit = config('catalog.max_limit', 100);
        $defaultLimit = config('catalog.default_limit', 50);

        $limit = $limit == 0 ? $defaultLimit : $limit;
        $limit = $limit > $maxLimit ? $maxLimit : $limit;

        $model = $model->limit($limit);

        if ($offset && $limit) {
            $model = $model->skip($offset);
        }

        return $model;
    }
}
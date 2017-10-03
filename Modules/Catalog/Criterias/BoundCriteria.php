<?php namespace Modules\Catalog\Criterias;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;

class BoundCriteria implements CriteriaInterface
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
        $bound = $this->request->get('bound');
        $bound = explode(",", $bound);

        if (!empty($bound) && count($bound) == 4) {
            $field = sprintf("(ST_GeomFromText('POINT(' || point || ')') && 
                ST_MakeEnvelope('%s', '%s', '%s', '%s', 4326))", $bound[0], $bound[1], $bound[2], $bound[3]);
            $model = $model->whereRaw($field);
        }
        return $model;
    }
}
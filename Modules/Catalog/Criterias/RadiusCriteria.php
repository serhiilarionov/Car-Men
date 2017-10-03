<?php namespace Modules\Catalog\Criterias;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;

class RadiusCriteria implements CriteriaInterface
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
        $lat = $this->request->header('lat');
        $lng = $this->request->header('lng');
        $radius = $this->request->get('radius');

        if (!empty($lat) && !empty($lng) && !empty($radius)) {
            $field = sprintf("ST_PointInsideCircle(
              ST_GeomFromText('POINT(' || point || ')'), '%s', '%s', '%s')", $lat, $lng, $radius);
            $model = $model->whereRaw($field);
        }
        return $model;
    }
}
<?php namespace Modules\Catalog\Criterias;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Phaza\LaravelPostgis\Geometries\Point;
use Illuminate\Support\Facades\DB;

class DistanceCriteria implements CriteriaInterface
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
        $point = new Point($lat, $lng);
        if (!empty($lat) && !empty($lng)) {
            $field = DB::raw(sprintf("ST_Distance_sphere(ST_GeomFromText('POINT(' || point || ')'), ST_GeomFromText('%s', 4326)) as distance",
              $point->toWKT()
            ));
            $model = $model->addSelect(['*', $field]);
        }
        return $model;
    }
}
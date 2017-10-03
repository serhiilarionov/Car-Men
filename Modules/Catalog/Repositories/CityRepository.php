<?php

namespace Modules\Catalog\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\City;
use InfyOm\Generator\Common\BaseRepository;

class CityRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'point',
        'bound',
        'active'
    ];

    protected $skipPresenter = true;

    /**
     * Configure the Model
     **/
    public function model()
    {
        return City::class;
    }

    /**
     * Configure presenter
     */
    public function presenter()
    {
        return "Modules\\Catalog\\Presenters\\CityPresenter";
    }

    /**
     * Find city by point
     *
     * @param $lat
     * @param $lng
     * @return City
     */
    public function findByPoint($lat, $lng)
    {
        $cityList = DB::select("SELECT catalog_city.id from catalog_city where ST_GeomFromText('POINT({$lng} {$lat})', 4326) && ST_MakeEnvelope(cast(split_part(catalog_city.bound, ', ', 1) as FLOAT), cast(split_part(catalog_city.bound, ', ', 2) as FLOAT),
cast(split_part(catalog_city.bound, ', ', 3) as FLOAT), cast(split_part(catalog_city.bound, ', ', 4) as FLOAT))");

        if (!is_array($cityList) || count($cityList) == 0) {
            return false;
        }

        $city = array_first($cityList);
        $city = $this->model->where('id', $city->id)->has('companies')->first();

        return $city;
    }

    public function hasCompany()
    {
        return $this->model->has('companies')->get();
    }
}

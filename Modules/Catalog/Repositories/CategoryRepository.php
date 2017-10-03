<?php

namespace Modules\Catalog\Repositories;

use Illuminate\Support\Facades\Session;
use Modules\Catalog\Entities\Category;
use InfyOm\Generator\Common\BaseRepository;
use Modules\Catalog\Entities\City;

class CategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'active',
        'parent_id'
    ];

    protected $skipPresenter = true;

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Category::class;
    }

    /**
     * Configure presenter
     */
    public function presenter()
    {
        return "Modules\\Catalog\\Presenters\\CategoryPresenter";
    }

    public function getMainCategory($cityId)
    {
        //save city for companies count
        Session::put('cityLocation', $cityId);
        // get parent categories by city which has companies
        $parent = City::whereId($cityId)->first()->categories->where('parent_id', null)->where('active', true);

        return $this->parserResult($parent);
    }
}

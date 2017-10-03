<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Support\Facades\Session;
use League\Fractal\TransformerAbstract;
use Modules\Catalog\Entities\Category;
use League\Fractal\Resource\Collection;
use Modules\Catalog\Entities\City;

/**
 * Class CategoryTransformer
 * @package namespace Modules\Catalog\Transformers;
 */
class CategoryTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'companies',
        'services',
        'subcategories'
    ];

    protected static $categoriesCount = null;

    /**
     * Transform the Category entity
     * @param Category $model
     *
     * @return array
     */
    public function transform(Category $model)
    {
        $result = [
            'id' => (int)$model->id,
            'name' => $model->name,
            'active' => $model->active,
            'parent_id' => $model->parent_id,
            'companies_count' => 0
        ];


        //add companies count
        if (is_null(self::$categoriesCount)) {
            $city = $this->getCityLocation();

            if ($city) {
                self::$categoriesCount = $city->categories->pluck('pivot.count', 'id')->toArray();
            }
        }

        if (is_array(self::$categoriesCount) && isset(self::$categoriesCount[$model->id])) {
            $result['companies_count'] = self::$categoriesCount[$model->id];
        }

        return $result;
    }

    protected function getCityLocation()
    {
        if (!Session::get('cityLocation')) {
            return null;
        }

        $cityId = (int)Session::get('cityLocation');
        $city = City::whereId($cityId)->with('categories')->first();

        return $city;
    }

    /**
     * Include Companies
     * @param Category $model
     *
     * @return Collection
     */
    public function includeCompanies(Category $model)
    {
        $companies = $model->companies;

        return $this->collection($companies, new CompanyTransformer);
    }

    /**
     * Include Companies
     * @param Category $model
     *
     * @return Collection
     */
    public function includeServices(Category $model)
    {
        $services = $model->services;

        return $this->collection($services, new ServiceTransformer);
    }

    public function includeSubcategories(Category $model)
    {

        $city = $this->getCityLocation();

        $children = $city->categories->where('parent_id', $model->id);

        return $this->collection($children, new CategoryTransformer());
    }

}

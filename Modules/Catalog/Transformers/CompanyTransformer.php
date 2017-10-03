<?php namespace Modules\Catalog\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Catalog\Entities\Company;
use League\Fractal\Resource\Collection;
use Modules\Catalog\Entities\Service;

/**
 * Class CompanyTransformer
 * @package namespace Modules\Catalog\Transformers;
 */
class CompanyTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'comforts',
        'categories',
        'detail',
        'catservices',
        'ratings',
        'ratingByUser',
    ];

    protected static $favorites = null;

    /**
     * Transform the Company entity
     * @param Company $model
     *
     * @return array
     */
    public function transform(Company $model)
    {
        $result = [
            'id' => (int)$model->id,
            'name' => $model->name,
            'city_id' => $model->city_id,
            'address' => $model->address,
            'point' => $model->point,
            'short_desc' => $model->short_desc,
            'picture' => $model->picture,
            'rating' => number_format($model->rating, 0),
            'price_rel' => $model->price_rel,
            'is_favorite' => false,
            'distance' => $model->distance,
        ];

        if (!\Auth::check()) {
            return $result;
        }

        //get user favorite companies
        if (!self::$favorites) {
            $user = \Auth::user();
            self::$favorites = array_flip($user->favorites->pluck('id')->toArray());
        }

        //add flag for favorite companies
        if (self::$favorites && isset(self::$favorites[$model->id])) {
            $result['is_favorite'] = true;
        }

        return $result;
    }

    /**
     * Include Comforts
     * @param Company $model
     *
     * @return Collection
     */
    public function includeComforts(Company $model)
    {
        $comforts = $model->comforts;

        return $this->collection($comforts, new ComfortTransformer);
    }

    /*
     * Include Categories
     * @param Company $model
     *
     * @return Collection
     */
    /*public function includeCategories(Company $model)
    {
        $categories = $model->categories;

        return $this->collection($categories, new CategoryTransformer);
    }*/


    /**
     * Include Detail
     * @param Company $model
     *
     * @return item
     */
    public function includeDetail(Company $model)
    {
        $detail = $model->detail;

        return $this->item($detail, new CompanyDetailTransformer);
    }

    /**
     * Include Categories
     * @param Company $model
     *
     * @return Collection
     */
    public function includeCategories(Company $model)
    {
        $services = $model->services;
        $categories = $model->categories;

        return $this->collection($categories, new CategoryServiceTransformer($services, $model));
    }

    /**
     * Include Ratings
     * @param Company $model
     *
     * @return Collection
     */
    public function includeRatings(Company $model)
    {
        $ratings = $model->ratings;

        return $this->collection($ratings, new CompanyRatingTransformer);
    }

    /**
     * Include Rating by user
     * @param Company $model
     *
     * @return Collection
     */
    public function includeRatingByUser(Company $model)
    {
        $ratings = $model->ratingByUser;

        return $this->collection($ratings, new CompanyRatingTransformer);
    }

}

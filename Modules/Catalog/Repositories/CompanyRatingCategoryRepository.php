<?php

namespace Modules\Catalog\Repositories;

use Modules\Catalog\Entities\CompanyRating;
use Modules\Catalog\Entities\CompanyRatingCategory;
use InfyOm\Generator\Common\BaseRepository;

class CompanyRatingCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_rating_id',
        'category_id',
        'rating'
    ];

    protected $skipPresenter = true;

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CompanyRatingCategory::class;
    }

    /**
     * Configure presenter
     */
    public function presenter()
    {
        return "Modules\\Catalog\\Presenters\\CompanyRatingCategoryPresenter";
    }

    /**
     * Get category ratings with data (if exist)
     *
     * @param $ratingId
     * @return array
     */
    public function getFilledByRating($ratingId)
    {
        $result = [];

        $rating = CompanyRating::with('company.categories')->findOrFail($ratingId);

        //get company's categories for rating
        $companyCategories = $rating->company->categories;

        if (! $companyCategories) {
            return $result;
        }

        //get existing categories
        $ratingCategories = $this->skipPresenter(true)->findByField('company_rating_id', $ratingId);
        $arrRatingCategories = $ratingCategories->pluck('rating', 'category_id');

        //add rating to categories
        foreach ($companyCategories as $category) {
            $result[] = [
                'category_id' => $category->id,
                'category_name' => $category->name,
                'rating' => isset($arrRatingCategories[$category->id]) ? $arrRatingCategories[$category->id] : null,
                'company_rating_id' => $ratingId,
            ];
        }

        return $result;
    }
}

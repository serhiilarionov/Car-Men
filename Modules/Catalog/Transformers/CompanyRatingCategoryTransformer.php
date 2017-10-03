<?php

namespace Modules\Catalog\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Catalog\Entities\CompanyRatingCategory;

/**
 * Class CompanyRatingCategoryTransformer
 * @package namespace Modules\Catalog\Transformers;
 */
class CompanyRatingCategoryTransformer extends TransformerAbstract
{

    /**
     * Transform the \CompanyRatingCategory entity
     * @param CompanyRatingCategory $model
     *
     * @return array
     */
    public function transform($model)
    {
        return [
            'company_rating_id' => $model['company_rating_id'],
            'category_id' => $model['category_id'],
            'category_name' => $model['category_name'],
            'rating' => $model['rating'],
        ];
    }
}

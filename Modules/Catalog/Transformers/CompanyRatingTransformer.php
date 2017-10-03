<?php

namespace Modules\Catalog\Transformers;

use Illuminate\Support\Facades\App;
use League\Fractal\TransformerAbstract;
use Modules\Catalog\Entities\CompanyRating;
use League\Fractal\Resource\Collection;
use Modules\Catalog\Repositories\CompanyRatingCategoryRepository;

/**
 * Class CompanyRatingTransformer
 * @package namespace Modules\Catalog\Transformers;
 */
class CompanyRatingTransformer extends TransformerAbstract
{

    /**
     * Include resources without needing it to be requested.
     *
     * @var array
     */
    protected $defaultIncludes = ['company_rating_categories'];


    /**
     * Transform the \CompanyRating entity
     * @param CompanyRating $model
     *
     * @return array
     */
    public function transform(CompanyRating $model)
    {
        return [
            'id' => (int)$model->id,
            'company_id' => $model->company_id,
            'display_name' => $model->display_name,
            'title' => $model->title,
            'text' => $model->text,
            'total_rating' => number_format($model->total_rating, 0),
            'price_rel' => $model->price_rel,
            'answer_name' => $model->answer_name,
            'answer_text' => $model->answer_text,
            'answer_date' => is_object($model->answer_date) ? $model->answer_date->toDateTimeString() : $model->anser_date,
            'created_at' => is_object($model->created_at) ? $model->created_at->toDateTimeString() : $model->created_at,
        ];
    }


    /**
     * Include Company Rating Categories
     * @param CompanyRating $model
     *
     * @return Collection
     */
    public function includeCompanyRatingCategories(CompanyRating $model)
    {
        $companyRatingCategoryRepository = new CompanyRatingCategoryRepository(App::getFacadeRoot());

        $companyRatingCategories = $companyRatingCategoryRepository->getFilledByRating($model->id);

        return $this->collection($companyRatingCategories, new CompanyRatingCategoryTransformer);
    }
}

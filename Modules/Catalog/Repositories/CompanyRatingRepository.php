<?php

namespace Modules\Catalog\Repositories;

use Illuminate\Support\Collection;
use Modules\Catalog\Entities\Company;
use Modules\Catalog\Entities\CompanyRating;
use InfyOm\Generator\Common\BaseRepository;

class CompanyRatingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'user_id',
        'display_name',
        'title',
        'text',
        'total_rating',
        'price_rel',
        'answer_name',
        'answer_text',
        'answer_date'
    ];

    protected $skipPresenter = true;

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CompanyRating::class;
    }

    /**
     * Configure presenter
     */
    public function presenter()
    {
        return "Modules\\Catalog\\Presenters\\CompanyRatingPresenter";
    }

    /**
     * Recalculate company rating
     * @param $companyId
     * @return mixed
     */
    public function recalculate($companyId)
    {
        $company = Company::whereId($companyId)->with('ratings')->firstOrFail();

        $ratingAvg = $company->ratings->avg('total_rating');
        $priceRelAvg = $company->ratings->avg('price_rel');


        if ($ratingAvg) {
            $company->rating = $ratingAvg;
            $company->save();
        }

        if ($priceRelAvg) {
            $company->price_rel = $priceRelAvg;
            $company->save();
        }


        return ['rating' => $ratingAvg, 'price_rel' => $priceRelAvg];

    }
}

<?php

namespace Modules\Catalog\Tests\Traits;

use Faker\Factory as Faker;
use Modules\Catalog\Entities\CompanyRating;
use Modules\Catalog\Repositories\CompanyRatingRepository;
use Modules\Catalog\Tests\Traits\MakeCompanyTrait;

trait MakeCompanyRatingTrait
{

    use MakeCompanyTrait;

    /**
     * Create fake instance of CompanyRating and save it in database
     *
     * @param array $companyRatingFields
     * @return CompanyRating
     */
    public function makeCompanyRating($companyRatingFields = [])
    {
        /** @var CompanyRatingRepository $companyRatingRepo */
        $companyRatingRepo = \App::make(CompanyRatingRepository::class);
        $theme = $this->fakeCompanyRatingData($companyRatingFields);

        return $companyRatingRepo->create($theme);
    }

    /**
     * Get fake instance of CompanyRating
     *
     * @param array $companyRatingFields
     * @return CompanyRating
     */
    public function fakeCompanyRating($companyRatingFields = [])
    {
        return new CompanyRating($this->fakeCompanyRatingData($companyRatingFields));
    }

    /**
     * Get fake data of CompanyRating
     *
     * @param array $companyRatingFields
     * @return array
     */
    public function fakeCompanyRatingData($companyRatingFields = [])
    {
        $fake = Faker::create();
        $company = $this->makeCompany();
        return array_merge([
            'company_id' => $company->id,
            'user_id' => 1,
            'display_name' => $fake->name,
            'title' => $fake->text,
            'text' => $fake->text,
            'total_rating' => $fake->numberBetween(1, 5),
            'price_rel' => $fake->numberBetween(1, 4),
            'answer_name' => $fake->name,
            'answer_text' => $fake->text,
            'answer_date' => $fake->date('Y-m-d H:i:s'),
                ], $companyRatingFields);
    }

}

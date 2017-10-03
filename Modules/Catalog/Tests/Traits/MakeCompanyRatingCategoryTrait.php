<?php namespace Modules\Catalog\Tests\Traits;

use Faker\Factory as Faker;
use Modules\Catalog\Entities\CompanyRatingCategory;
use Modules\Catalog\Repositories\CompanyRatingCategoryRepository;

trait MakeCompanyRatingCategoryTrait
{
    /**
     * Create fake instance of CompanyRatingCategory and save it in database
     *
     * @param array $companyRatingCategoryFields
     * @return CompanyRatingCategory
     */
    public function makeCompanyRatingCategory($companyRatingCategoryFields = [])
    {
        /** @var CompanyRatingCategoryRepository $companyRatingCategoryRepo */
        $companyRatingCategoryRepo = \App::make(CompanyRatingCategoryRepository::class);
        $theme = $this->fakeCompanyRatingCategoryData($companyRatingCategoryFields);
        return $companyRatingCategoryRepo->create($theme);
    }

    /**
     * Get fake instance of CompanyRatingCategory
     *
     * @param array $companyRatingCategoryFields
     * @return CompanyRatingCategory
     */
    public function fakeCompanyRatingCategory($companyRatingCategoryFields = [])
    {
        return new CompanyRatingCategory($this->fakeCompanyRatingCategoryData($companyRatingCategoryFields));
    }

    /**
     * Get fake data of CompanyRatingCategory
     *
     * @param array $companyRatingCategoryFields
     * @return array
     */
    public function fakeCompanyRatingCategoryData($companyRatingCategoryFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'company_rating_id' => 1,
            'category_id' => 1,
            'rating' => $fake->randomNumber(1),
        ], $companyRatingCategoryFields);
    }
}

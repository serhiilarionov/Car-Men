<?php

namespace Modules\Catalog\Tests\Traits;

use Faker\Factory as Faker;
use Modules\Catalog\Entities\Company;
use Modules\Catalog\Repositories\CompanyRepository;

trait MakeCompanyTrait
{

    /**
     * Create fake instance of Company and save it in database
     *
     * @param array $companyFields
     * @return Company
     */
    public function makeCompany($companyFields = [])
    {
        /** @var CompanyRepository $companyRepo */
        $companyRepo = \App::make(CompanyRepository::class);
        $theme = $this->fakeCompanyData($companyFields);

        return $companyRepo->create($theme);
    }

    /**
     * Get fake instance of Company
     *
     * @param array $companyFields
     * @return Company
     */
    public function fakeCompany($companyFields = [])
    {
        return new Company($this->fakeCompanyData($companyFields));
    }

    /**
     * Get fake data of Company
     *
     * @param array $companyFields
     * @return array
     */
    public function fakeCompanyData($companyFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'city_id' => 1,
            'address' => $fake->word,
            'point' => [
                'lat' => $fake->randomDigitNotNull,
                'lng' => $fake->randomDigitNotNull
            ],
            'short_desc' => $fake->word,
            'picture' => $fake->word,
            'rating' => $fake->randomDigitNotNull,
            'price_rel' => $fake->randomDigitNotNull
        ], $companyFields);
    }

}

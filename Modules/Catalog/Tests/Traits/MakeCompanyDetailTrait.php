<?php namespace Modules\Catalog\Tests\Traits;

use Faker\Factory as Faker;
use Modules\Catalog\Entities\CompanyDetail;
use Modules\Catalog\Repositories\CompanyDetailRepository;

trait MakeCompanyDetailTrait
{
    /**
     * Create fake instance of CompanyDetail and save it in database
     *
     * @param array $companyDetailFields
     * @return CompanyDetail
     */
    public function makeCompanyDetail($companyDetailFields = [])
    {
        /** @var CompanyDetailRepository $companyDetailRepo */
        $companyDetailRepo = \App::make(CompanyDetailRepository::class);
        $theme = $this->fakeCompanyDetailData($companyDetailFields);

        return $companyDetailRepo->create($theme);
    }

    /**
     * Get fake instance of CompanyDetail
     *
     * @param array $companyDetailFields
     * @return CompanyDetail
     */
    public function fakeCompanyDetail($companyDetailFields = [])
    {
        return new CompanyDetail($this->fakeCompanyDetailData($companyDetailFields));
    }

    /**
     * Get fake data of CompanyDetail
     *
     * @param array $companyDetailFields
     * @return array
     */
    public function fakeCompanyDetailData($companyDetailFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'phones' => json_encode($fake->word),
            'email' => $fake->word,
            'website' => $fake->word,
            'work_time' => json_encode($fake->word),
            'desc' => $fake->word,
            'company_id' => null
        ], $companyDetailFields);
    }
}

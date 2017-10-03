<?php

namespace Modules\Catalog\Tests\API;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Catalog\Tests\Traits\MakeCompanyTrait;
use Tests\ApiTestTrait;
use Tests\TestCase;
use Modules\Catalog\Entities\Company;
use Modules\Catalog\Entities\City;
use Modules\Catalog\Entities\CatalogCityCompanyPopular;

class CompanyApiTest extends TestCase
{

    use MakeCompanyTrait,
        ApiTestTrait,
        WithoutMiddleware,
        DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCompany()
    {
        $company = $this->fakeCompanyData();
        $company['categories'] = [0];
        $this->json('POST', '/api/v1/catalog/companies', $company);
        unset($company['categories']);
        $this->assertApiResponse($company);
    }

    /**
     * @test
     */
    public function testReadCompany()
    {
        $company = $this->makeCompany();
        $this->json('GET', '/api/v1/catalog/companies/' . $company->id);
        $this->assertApiResponse($company->presenter()['data']);
    }

    public function testReadCompanies()
    {
        $companies = Company::all();
        $this->json('GET', '/api/v1/catalog/companies');
        $this->assertApiCheckLenghtWithPaginate($companies->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCompany()
    {
        $company = $this->makeCompany();
        $editedCompany = $this->fakeCompanyData();
        $editedCompany['categories'] = [0];
        $this->json('PUT', '/api/v1/catalog/companies/' . $company->id, $editedCompany);
        unset($editedCompany['categories']);
        $this->assertApiResponse($editedCompany);
    }

    /**
     * @test
     */
    public function testDeleteCompany()
    {
        $company = $this->makeCompany();
        $this->json('DELETE', '/api/v1/catalog/companies/' . $company->id);

        $this->json('GET', '/api/v1/catalog/companies/' . $company->id);
        $this->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function testPopularCompaniesByCity()
    {
        $cityName = 'Киев';
        $cityId = City::where('name', $cityName)->value('id');
        $companiesIdPopular = CatalogCityCompanyPopular::select('company_id as id')
                        ->where('city_id', $cityId)
                        ->orderBy('total', 'desc')
                        ->limit(1)->get();
        $this->json('GET', '/api/v1/catalog/companies/popularByCity/' . $cityId);

        $this->assertApiPopularCompaniesByCity($companiesIdPopular->toArray());
    }

    /**
     * @test
     */
    public function testReadCompaniesByBound()
    {
        echo '                              No test - testReadCompaniesByBound';
    }

    /**
     * @test
     */
    public function testReadCompaniesInRadius()
    {
        echo '                              No test - testReadCompaniesInRadius';
    }

}

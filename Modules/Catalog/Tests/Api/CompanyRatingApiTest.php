<?php

namespace Modules\Catalog\Tests\API;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Catalog\Tests\Traits\MakeCompanyRatingTrait;
use Tests\ApiTestTrait;
use Tests\TestCase;
use Modules\Catalog\Entities\CompanyRating;

class CompanyRatingApiTest extends TestCase
{

    use MakeCompanyRatingTrait,
        ApiTestTrait,
        WithoutMiddleware,
        DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCompanyRating()
    {
        $companyRating = $this->fakeCompanyRatingData();
        $login = '&email=admin@admin.com' . '&password=a12365478';
        $this->json('POST', '/api/v1/auth/users/login?' . $login);
        $token = json_decode($this->response->getContent(), true)['data']['token'];
        $this->json('POST', '/api/v1/catalog/companies/ratings?token=' . $token, $companyRating);
        $this->assertApiResponse($companyRating);
    }

    /**
     * @test
     */
    public function testReadCompanyRating()
    {
        $companyId = CompanyRating::orderBy('id')->first()->value('company_id');
        $companyRating = CompanyRating::where('company_id', $companyId)->get();
        $this->json('GET', '/api/v1/catalog/companies/' . $companyId . '/ratings');
        $this->assertApiCheckLenght($companyRating->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCompanyRating()
    {
        $companyRating = $this->makeCompanyRating();
        $editedCompanyRating = $this->fakeCompanyRatingData();
        $this->json('PUT', '/api/v1/catalog/companies/ratings/' . $companyRating->id, $editedCompanyRating);
        unset($editedCompanyRating['user_id']);
        $this->assertApiResponse($editedCompanyRating);
    }

}

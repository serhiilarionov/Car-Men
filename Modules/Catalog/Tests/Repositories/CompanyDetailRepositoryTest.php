<?php namespace Modules\Catalog\Tests\Repositories;

use Modules\Catalog\Entities\CompanyDetail;
use Modules\Catalog\Repositories\CompanyDetailRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Catalog\Tests\Traits\MakeCompanyTrait;
use Modules\Catalog\Tests\Traits\MakeCompanyDetailTrait;
use Tests\ApiTestTrait;
use Tests\TestCase;

class CompanyDetailRepositoryTest extends TestCase
{
    use MakeCompanyTrait, MakeCompanyDetailTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CompanyDetailRepository
     */
    protected $companyDetailRepo;

    public function setUp()
    {
        parent::setUp();
        $this->companyDetailRepo = \App::make(CompanyDetailRepository::class);
    }

//    /**
//     * @test create
//     */
//    public function testCreateCompanyDetail()
//    {
//        $company = $this->makeCompany();
//        $companyDetail = $this->fakeCompanyDetailData();
//        $companyDetail['company_id'] = $company->id;
//        $createdCompanyDetail = $this->companyDetailRepo->create($companyDetail);
//        $createdCompanyDetail = $createdCompanyDetail->toArray();
//        $this->assertArrayHasKey('company_id', $createdCompanyDetail);
//        $this->assertNotNull($createdCompanyDetail['company_id'], 'Created CompanyDetail must have company_id specified');
//        $this->assertNotNull(CompanyDetail::find($createdCompanyDetail['company_id']),
//          'CompanyDetail with given company_id must be in DB');
//        $this->assertModelData($companyDetail, $createdCompanyDetail);
//    }

    /**
     * @test read
     */
    public function testReadCompanyDetail()
    {
        $company = $this->makeCompany();
        $companyDetail = $this->makeCompanyDetail(['company_id' => $company->id]);
        $dbCompanyDetail = $this->companyDetailRepo->find($companyDetail->company_id);
        $dbCompanyDetail = $dbCompanyDetail->toArray();
        $this->assertModelData($companyDetail->toArray(), $dbCompanyDetail);
    }

//    /**
//     * @test update
//     */
//    public function testUpdateCompanyDetail()
//    {
//        $company = $this->makeCompany();
//        $companyDetail = $this->makeCompanyDetail(['company_id' => $company->id]);
//        $fakeCompanyDetail = $this->fakeCompanyDetailData();
//        $fakeCompanyDetail['company_id'] = $company->id;
//        $updatedCompanyDetail = $this->companyDetailRepo->update($fakeCompanyDetail, $companyDetail->company_id);
//        $this->assertModelData($fakeCompanyDetail, $updatedCompanyDetail->toArray());
//        $dbCompanyDetail = $this->companyDetailRepo->find($companyDetail->company_id);
//        $this->assertModelData($fakeCompanyDetail, $dbCompanyDetail->toArray());
//    }
//
//    /**
//     * @test delete
//     */
//    public function testDeleteCompanyDetail()
//    {
//        $company = $this->makeCompany();
//        $companyDetail = $this->makeCompanyDetail(['company_id' => $company->id]);
//        $resp = $this->companyDetailRepo->delete($companyDetail->company_id);
//        $this->assertTrue($resp);
//        $this->assertNull(CompanyDetail::find($companyDetail->company_id), 'CompanyDetail should not exist in DB');
//    }
}

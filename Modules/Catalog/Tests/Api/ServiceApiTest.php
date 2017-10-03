<?php namespace Modules\Catalog\Tests\API;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Catalog\Tests\Traits\MakeServiceTrait;
use Tests\ApiTestTrait;
use Tests\TestCase;
use Modules\Catalog\Entities\Service;

class ServiceApiTest extends TestCase
{
    use MakeServiceTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testReadServices()
    {
        $service = Service::all();
        
        $this->json('GET', '/api/v1/catalog/services');

        $this->assertApiCheckLenght($service->toArray());
    }
    
    /**
     * @test
     */
    public function testCreateService()
    {
        $service = $this->fakeServiceData();
        $this->json('POST', '/api/v1/catalog/services', $service);

        $this->assertApiResponse($service);
    }

    /**
     * @test
     */
    public function testReadService()
    {
        $service = $this->makeService();
        $this->json('GET', '/api/v1/catalog/services/' . $service->id);

        $this->assertApiResponse($service->presenter()['data']);
    }

    /**
     * @test
     */
    public function testUpdateService()
    {
        $service = $this->makeService();
        $editedService = $this->fakeServiceData();

        $this->json('PUT', '/api/v1/catalog/services/' . $service->id, $editedService);

        $this->assertApiResponse($editedService);
    }

    /**
     * @test
     */
    public function testDeleteService()
    {
        $service = $this->makeService();
        $this->json('DELETE', '/api/v1/catalog/services/' . $service->id);

        $this->json('GET', '/api/v1/catalog/services/' . $service->id);
        $this->assertResponseStatus(404);
    }
}

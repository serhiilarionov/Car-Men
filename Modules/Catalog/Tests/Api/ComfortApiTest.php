<?php namespace Modules\Catalog\Tests\API;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Catalog\Tests\Traits\MakeComfortTrait;
use Tests\ApiTestTrait;
use Tests\TestCase;
use Modules\Catalog\Entities\Comfort;

class ComfortApiTest extends TestCase
{
    use MakeComfortTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testReadComfort()
    {
        $comfort = $this->makeComfort();
        $this->json('GET', '/api/v1/catalog/comforts/' . $comfort->id);
        $this->assertApiResponse($comfort->presenter()['data']);
    }
    
    public function testReadComforts()
    {
        $comfort = Comfort::all();
        $this->json('GET', '/api/v1/catalog/comforts/');
        $this->assertApiCheckLenght($comfort->toArray());
    }

}    

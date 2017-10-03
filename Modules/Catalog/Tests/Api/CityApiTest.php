<?php namespace Modules\Catalog\Tests\API;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Catalog\Tests\Traits\MakeCityTrait;
use Tests\ApiTestTrait;
use Tests\TestCase;
use Modules\Catalog\Entities\City;

class CityApiTest extends TestCase
{
    use MakeCityTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testReadCity()
    {
        $city = $this->makeCity();
        $this->json('GET', '/api/v1/catalog/cities/' . $city->id);
        $this->assertApiResponse($city->presenter()['data']);
    }
    
    /**
     * @test
     */
    public function testReadCities()
    {
        $cities = City::has('companies')->get();
        $this->json('GET', '/api/v1/catalog/cities');
        $this->assertApiCheckLenght($cities->toArray());
    }

    /**
     * @test
     */
    public function testReadCityByPoint()
    {
        echo '                      No work - testReadCityByPoint';
    }
}

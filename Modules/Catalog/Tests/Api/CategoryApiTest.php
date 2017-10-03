<?php

namespace Modules\Catalog\Tests\API;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Catalog\Tests\Traits\MakeCategoryTrait;
use Tests\ApiTestTrait;
use Tests\TestCase;
use Modules\Catalog\Entities\City;
use Modules\Catalog\Entities\Category;

class CategoryApiTest extends TestCase
{

    use MakeCategoryTrait,
        ApiTestTrait,
        WithoutMiddleware,
        DatabaseTransactions;

    /**
     * @test
     */
    public function testReadCategory()
    {
        $category = $this->makeCategory();
        $this->json('GET', '/api/v1/catalog/categories/' . $category->id);
        $this->assertApiResponse($category->presenter()['data']);
    }

    /**
     * @test
     */
    public function testReadCategories()
    {
        $cityName = 'Киев';
        $cityId = City::where('name', $cityName)->value('id');
        $categories = City::whereId($cityId)->first()->categories->where('parent_id', null)->where('active', true);
        $this->json('GET', '/api/v1/catalog/categories?cityId=' . $cityId);
        $this->assertApiCheckLenght($categories->toArray());
    }

    /**
     * @test
     */
    public function testReadCompaniesByCategore()
    {
        $categoryName = 'Шиномонтаж';
        $categoryId = Category::where('name', $categoryName)->value('id');
        $companies = Category::whereId($categoryId)->first()->companies->where('deleted_at', null);
        $this->json('GET', '/api/v1/catalog/categories/' . $categoryId . '/companies');
        $this->assertApiCheckLenghtWithPaginate($companies->toArray());
    }

}

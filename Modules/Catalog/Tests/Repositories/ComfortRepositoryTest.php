<?php namespace Modules\Catalog\Tests\Repositories;

use Modules\Catalog\Entities\Comfort;
use Modules\Catalog\Repositories\ComfortRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Catalog\Tests\Traits\MakeComfortTrait;
use Tests\ApiTestTrait;
use Tests\TestCase;

class ComfortRepositoryTest extends TestCase
{
    use MakeComfortTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ComfortRepository
     */
    protected $comfortRepo;

    public function setUp()
    {
        parent::setUp();
        $this->comfortRepo = \App::make(ComfortRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateComfort()
    {
        $comfort = $this->fakeComfortData();
        $createdComfort = $this->comfortRepo->create($comfort);
        $createdComfort = $createdComfort->toArray();
        $this->assertArrayHasKey('id', $createdComfort);
        $this->assertNotNull($createdComfort['id'], 'Created Comfort must have id specified');
        $this->assertNotNull(Comfort::find($createdComfort['id']), 'Comfort with given id must be in DB');
        $this->assertModelData($comfort, $createdComfort);
    }

    /**
     * @test read
     */
    public function testReadComfort()
    {
        $comfort = $this->makeComfort();
        $dbComfort = $this->comfortRepo->find($comfort->id);
        $dbComfort = $dbComfort->toArray();
        $this->assertModelData($comfort->toArray(), $dbComfort);
    }

    /**
     * @test update
     */
    public function testUpdateComfort()
    {
        $comfort = $this->makeComfort();
        $fakeComfort = $this->fakeComfortData();
        $updatedComfort = $this->comfortRepo->update($fakeComfort, $comfort->id);
        $this->assertModelData($fakeComfort, $updatedComfort->toArray());
        $dbComfort = $this->comfortRepo->find($comfort->id);
        $this->assertModelData($fakeComfort, $dbComfort->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteComfort()
    {
        $comfort = $this->makeComfort();
        $resp = $this->comfortRepo->delete($comfort->id);
        $this->assertTrue($resp);
        $this->assertNull(Comfort::find($comfort->id), 'Comfort should not exist in DB');
    }
}

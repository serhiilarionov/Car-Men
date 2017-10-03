<?php namespace Modules\Auth\Tests\Repositories;

use Modules\Auth\Entities\PushLog;
use Modules\Auth\Repositories\PushLogRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Auth\Tests\Traits\MakePushLogTrait;
use Tests\ApiTestTrait;
use Tests\TestCase;

class PushLogRepositoryTest extends TestCase
{
    use MakePushLogTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PushLogRepository
     */
    protected $pushLogRepo;

    public function setUp()
    {
        parent::setUp();
        $this->pushLogRepo = \App::make(PushLogRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePushLog()
    {
        $pushLog = $this->fakePushLogData();
        $createdPushLog = $this->pushLogRepo->create($pushLog);
        $createdPushLog = $createdPushLog->toArray();
        $this->assertArrayHasKey('id', $createdPushLog);
        $this->assertNotNull($createdPushLog['id'], 'Created PushLog must have id specified');
        $this->assertNotNull(PushLog::find($createdPushLog['id']), 'PushLog with given id must be in DB');
        $this->assertModelData($pushLog, $createdPushLog);
    }

    /**
     * @test read
     */
    public function testReadPushLog()
    {
        $pushLog = $this->makePushLog();
        $dbPushLog = $this->pushLogRepo->find($pushLog->id);
        $dbPushLog = $dbPushLog->toArray();
        $this->assertModelData($pushLog->toArray(), $dbPushLog);
    }

    /**
     * @test update
     */
    public function testUpdatePushLog()
    {
        $pushLog = $this->makePushLog();
        $fakePushLog = $this->fakePushLogData();
        $updatedPushLog = $this->pushLogRepo->update($fakePushLog, $pushLog->id);
        $this->assertModelData($fakePushLog, $updatedPushLog->toArray());
        $dbPushLog = $this->pushLogRepo->find($pushLog->id);
        $this->assertModelData($fakePushLog, $dbPushLog->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePushLog()
    {
        $pushLog = $this->makePushLog();
        $resp = $this->pushLogRepo->delete($pushLog->id);
        $this->assertTrue($resp);
        $this->assertNull(PushLog::find($pushLog->id), 'PushLog should not exist in DB');
    }
}

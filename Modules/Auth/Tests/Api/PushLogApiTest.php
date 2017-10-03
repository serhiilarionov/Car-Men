<?php namespace Modules\Auth\Tests\API;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Auth\Tests\Traits\MakePushLogTrait;
use Tests\ApiTestTrait;
use Tests\TestCase;

class PushLogApiTest extends TestCase
{
    use MakePushLogTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
    */ 
    public function testCreatePushLog()
    {
        echo '                      No work - testCreatePushLog';
//        $pushLog = $this->fakePushLogData();
//        $this->json('POST', '/api/v1/$MODULE_NAME_SMALL$/pushLogs', $pushLog);
//
//        $this->assertApiResponse($pushLog);
    }

    /**
     * @test
     */
    public function testReadPushLog()
    {
        echo '                      No work - testReadPushLog';
//        $pushLog = $this->makePushLog();
//        $this->json('GET', '/api/v1/$MODULE_NAME_SMALL$/pushLogs/'.$pushLog->id);
//
//        $this->assertApiResponse($pushLog->presenter()['data']);
    }

    /**
     * @test
    */ 
    public function testUpdatePushLog()
    {
        echo '                      No work - testUpdatePushLog';
//        $pushLog = $this->makePushLog();
//        $editedPushLog = $this->fakePushLogData();
//
//        $this->json('PUT', '/api/v1/$MODULE_NAME_SMALL$/pushLogs/'.$pushLog->id, $editedPushLog);
//
//        $this->assertApiResponse($editedPushLog);
    }

    /**
     * @test
    */ 
    public function testDeletePushLog()
    {
        echo '                      No work - testDeletePushLog';
//        $pushLog = $this->makePushLog();
//        $this->json('DELETE', '/api/v1/$MODULE_NAME_SMALL$/pushLogs/'.$pushLog->id);
//
//        $this->assertApiSuccess();
//        $this->json('GET', '/api/v1/$MODULE_NAME_SMALL$/pushLogs/'.$pushLog->id);
//
//        $this->assertResponseStatus(404);
    }
}

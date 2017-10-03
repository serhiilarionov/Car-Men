<?php namespace Modules\Auth\Tests\API;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Auth\Tests\Traits\MakeDeviceTrait;
use Tests\ApiTestTrait;
use Tests\TestCase;

class DeviceApiTest extends TestCase
{
    use MakeDeviceTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateDevice()
    {
        $device = $this->fakeDeviceData();
        $jsonData =
            'deviceId=' . $device['device_id']
            . '&pushToken=' . $device['push_token']
            . '&deviceType=' . $device['device_type'];
        
        $this->json('POST', '/api/v1/auth/devices/init?'.$jsonData);

        $responseCode = json_decode($this->response->getStatusCode(), true);
        
        $this->assertEquals(200, $responseCode);
    }

    /**
     * @test
     */
 /*   public function testReadDevice()
    {
        $device = $this->makeDevice();
        $this->json('GET', '/api/v1/device/devices/'.$device->id);

        $this->assertApiResponse($device->presenter()['data']);
    }

    /**
     * @test
     */
/*    public function testUpdateDevice()
    {
        $device = $this->makeDevice();
        $editedDevice = $this->fakeDeviceData();

        $this->json('PUT', '/api/v1/device/devices/'.$device->id, $editedDevice);

        $this->assertApiResponse($editedDevice);
    }

    /**
     * @test
     */
 /*  public function testDeleteDevice()
    {
        $device = $this->makeDevice();
        $this->json('DELETE', '/api/v1/device/devices/'.$device->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/device/devices/'.$device->id);

        $this->assertResponseStatus(404);
    }*/
}

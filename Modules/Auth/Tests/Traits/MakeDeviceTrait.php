<?php namespace Modules\Auth\Tests\Traits;

use Faker\Factory as Faker;
use Modules\Auth\Entities\Device;
use Modules\Auth\Repositories\DeviceRepository;

trait MakeDeviceTrait
{
    /**
     * Create fake instance of Device and save it in database
     *
     * @param array $deviceFields
     * @return Device
     */
    public function makeDevice($deviceFields = [])
    {
        /** @var DeviceRepository $deviceRepo */
        $deviceRepo = \App::make(DeviceRepository::class);
        $theme = $this->fakeDeviceData($deviceFields);
        return $deviceRepo->create($theme);
    }

    /**
     * Get fake instance of Device
     *
     * @param array $deviceFields
     * @return Device
     */
    public function fakeDevice($deviceFields = [])
    {
        return new Device($this->fakeDeviceData($deviceFields));
    }

    /**
     * Get fake data of Device
     *
     * @param array $deviceFields
     * @return array
     */
    public function fakeDeviceData($deviceFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => 1,//$fake->randomDigitNotNull,
            'device_id' => $fake->word,
            'push_token' => $fake->word,
            'device_type' => $fake->word,
            //'created_at' => $fake->date('Y-m-d H:i:s'),
            //'updated_at' => $fake->date('Y-m-d H:i:s')
        ], $deviceFields);
    }
}

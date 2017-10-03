<?php

namespace Modules\Auth\Repositories;

use Modules\Auth\Entities\Device;
use InfyOm\Generator\Common\BaseRepository;

class DeviceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'device_id',
        'push_token',
        'device_type'
    ];

    protected $skipPresenter = true;

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Device::class;
    }

    /**
     * Configure presenter
     */
    public function presenter()
    {
        return "Modules\\Auth\\Presenters\\DevicePresenter";
    }

    /**
     * get device if device set in DB
     *
     * @param $deviceId
     * @return bool|mixed
     */
    public function isSetDevice($deviceId)
    {
        $deviceId = Device::where('device_id', $deviceId)->pluck('id')->toArray();

        if (!empty($deviceId)) {
            return $deviceId[0];
        }
        return false;
    }
}

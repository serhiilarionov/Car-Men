<?php

namespace Modules\Auth\Http\Controllers\API;

use Illuminate\Support\Facades\Input;
use Modules\Auth\Http\Requests\API\CreateDeviceAPIRequest;
use Modules\Auth\Http\Requests\API\UpdateDeviceAPIRequest;
use Modules\Auth\Entities\Device;
use Modules\Auth\Repositories\DeviceRepository;
use Illuminate\Http\Request;
use Modules\Auth\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class DeviceController
 * @package Modules\Auth\Http\Controllers\API
 */

class DeviceAPIController extends AppBaseController
{
    /** @var  DeviceRepository */
    private $deviceRepository;

    public function __construct(DeviceRepository $deviceRepo)
    {
        $this->deviceRepository = $deviceRepo;
        $this->deviceRepository->skipPresenter(false);
    }


    /**
     * @return Response
     *
     * @SWG\Post(
     *      path="/auth/devices/init",
     *      summary="Init devices",
     *      tags={"Auth"},
     *      description="Init devices",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="deviceId",
     *          description="id of Device",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="pushToken",
     *          description="id of Device",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="deviceType",
     *          description="id of Device",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Device"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function init()
    {
        $input = Input::all();

        $data['device_id'] = $input['deviceId'];
        $data['push_token'] = $input['pushToken'];
        $data['device_type'] = $input['deviceType'];

        $deviceId = $this->deviceRepository->isSetDevice($input['deviceId']);
        
        if ($deviceId){
            $this->deviceRepository->update($data, $deviceId);
            return $this->sendResponse('success', 'Device updated successfully');
        } else {
            $this->deviceRepository->create($data);
            return $this->sendResponse('success', 'Device created successfully');
        }
    }
}

<?php

namespace Modules\Auth\Http\Controllers;

use Modules\Auth\DataTables\DeviceDataTable;
use Modules\Auth\Http\Requests;
use Modules\Auth\Http\Requests\CreateDeviceRequest;
use Modules\Auth\Http\Requests\UpdateDeviceRequest;
use Modules\Auth\Repositories\DeviceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class DeviceController extends AppBaseController
{
    /** @var  DeviceRepository */
    private $deviceRepository;

    public function __construct(DeviceRepository $deviceRepo)
    {
        $this->deviceRepository = $deviceRepo;
    }

    /**
     * Display a listing of the Device.
     *
     * @param DeviceDataTable $deviceDataTable
     * @return Response
     */
    public function index(DeviceDataTable $deviceDataTable)
    {
        return $deviceDataTable->render('device::devices.index');
    }

    /**
     * Show the form for creating a new Device.
     *
     * @return Response
     */
    public function create()
    {
        return view('device::devices.create');
    }

    /**
     * Store a newly created Device in storage.
     *
     * @param CreateDeviceRequest $request
     *
     * @return Response
     */
    public function store(CreateDeviceRequest $request)
    {
        $input = $request->all();

        $device = $this->deviceRepository->create($input);

        Flash::success('Device saved successfully.');

        return redirect(route('device.devices.index'));
    }

    /**
     * Display the specified Device.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $device = $this->deviceRepository->findWithoutFail($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('device.devices.index'));
        }

        return view('device::devices.show')->with('device', $device);
    }

    /**
     * Show the form for editing the specified Device.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $device = $this->deviceRepository->findWithoutFail($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('device.devices.index'));
        }

        return view('device::devices.edit')->with('device', $device);
    }

    /**
     * Update the specified Device in storage.
     *
     * @param  int              $id
     * @param UpdateDeviceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDeviceRequest $request)
    {
        $device = $this->deviceRepository->findWithoutFail($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('device.devices.index'));
        }

        $device = $this->deviceRepository->update($request->all(), $id);

        Flash::success('Device updated successfully.');

        return redirect(route('device.devices.index'));
    }

    /**
     * Remove the specified Device from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $device = $this->deviceRepository->findWithoutFail($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('device.devices.index'));
        }

        $this->deviceRepository->delete($id);

        Flash::success('Device deleted successfully.');

        return redirect(route('device.devices.index'));
    }
}

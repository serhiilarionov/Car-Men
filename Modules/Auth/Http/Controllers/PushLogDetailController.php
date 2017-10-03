<?php

namespace Modules\Auth\Http\Controllers;

use Modules\Auth\DataTables\PushLogDetailDataTable;
use Modules\Auth\Http\Requests;
use Modules\Auth\Http\Requests\UpdatePushLogRequest;
use Illuminate\Http\Request;
use Modules\Auth\Repositories\PushLogRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\Session;

class PushLogDetailController extends AppBaseController
{
    /** @var  PushLogRepository */
    private $pushLogRepository;

    public function __construct(PushLogRepository $pushLogRepo)
    {
        $this->pushLogRepository = $pushLogRepo;
    }

    /**
     * Display a listing of the PushLogDetail.
     *
     * @param PushLogDetailDataTable $pushLogDetailDataTable
     * @param Request $request
     * @return Response
     */
    public function index(PushLogDetailDataTable $pushLogDetailDataTable, Request $request)
    {
        $pushLogDay = $request->get('pushLogDay');

        if (!$pushLogDay) {
            Flash::error('Push log detail not found');

            return redirect(route('auth.pushLogs.index'));
        }
        Session::put('pushLogDay', $pushLogDay);

        return $pushLogDetailDataTable->setDay($pushLogDay)->render('auth::push_logs.details.index');
    }

    /**
     * Display the specified PushLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pushLog = $this->pushLogRepository->findWithoutFail($id);
        $pushLogDay = Session::get('pushLogDay');

        if (empty($pushLog)) {
            Flash::error('Push Log not found');

            return redirect(route('auth.pushLogDetails.index', ['pushLogDay' => $pushLogDay]));
        }

        return view('auth::push_logs.details.show')->with(compact('pushLog'));
    }

    /**
     * Show the form for editing the specified PushLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pushLog = $this->pushLogRepository->findWithoutFail($id);
        $pushLogDay = Session::get('pushLogDay');

        if (empty($pushLog)) {
            Flash::error('Push Log not found');

            return redirect(route('auth.pushLogDetails.index', ['pushLogDay' => $pushLogDay]));
        }

        return view('auth::push_logs.details.edit')->with(compact('pushLog'));
    }

    /**
     * Update the specified PushLog in storage.
     *
     * @param  int              $id
     * @param UpdatePushLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePushLogRequest $request)
    {
        $pushLog = $this->pushLogRepository->findWithoutFail($id);
        $pushLogDay = Session::get('pushLogDay');

        if (empty($pushLog)) {
            Flash::error('Push Log not found');

            return redirect(route('auth.pushLogDetails.index', ['pushLogDay' => $pushLogDay]));
        }

        $pushLog = $this->pushLogRepository->update($request->all(), $id);

        Flash::success('Push Log updated successfully.');

        return redirect(route('auth.pushLogDetails.index', ['pushLogDay' => $pushLogDay]));
    }

    /**
     * Remove the specified PushLog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pushLog = $this->pushLogRepository->findWithoutFail($id);
        $pushLogDay = Session::get('pushLogDay');

        if (empty($pushLog)) {
            Flash::error('Push Log not found');

            return redirect(route('auth.pushLogDetails.index', ['pushLogDay' => $pushLogDay]));
        }

        $this->pushLogRepository->delete($id);

        Flash::success('Push Log deleted successfully.');

        return redirect(route('auth.pushLogDetails.index', ['pushLogDay' => $pushLogDay]));
    }
}

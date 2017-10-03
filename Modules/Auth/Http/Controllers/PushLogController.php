<?php

namespace Modules\Auth\Http\Controllers;

use Modules\Auth\DataTables\PushLogDataTable;
use Modules\Auth\Http\Requests;
use Modules\Auth\Repositories\PushLogRepository;
use App\Http\Controllers\AppBaseController;
use Response;

class PushLogController extends AppBaseController
{
    /** @var  PushLogRepository */
    private $pushLogRepository;

    public function __construct(PushLogRepository $pushLogRepo)
    {
        $this->pushLogRepository = $pushLogRepo;
    }

    /**
     * Display a listing of the PushLog.
     *
     * @param PushLogDataTable $pushLogDataTable
     * @return Response
     */
    public function index(PushLogDataTable $pushLogDataTable)
    {
        return $pushLogDataTable->render('auth::push_logs.index');
    }
}

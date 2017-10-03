<?php

namespace Modules\Auth\DataTables;

use Modules\Auth\Entities\PushLog;
use Form;
use DB;
use Yajra\Datatables\Services\DataTable;

class PushLogDetailDataTable extends DataTable
{

    protected $pushLogDay;

    /**
     * Set day of push
     * @param $day
     * @return $this
     */
    public function setDay($day)
    {
        $this->pushLogDay = $day;

        return $this;
    }
    
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'auth::push_logs.details.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $pushLogs = PushLog::query()
            ->where(DB::raw("DATE(created_at)"), '=', $this->pushLogDay);

        return $this->applyScopes($pushLogs);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->addAction(['width' => '10%'])
            ->ajax('')
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'buttons' => [
                    'print',
                    'reset',
                    'reload',
                    [
                         'extend'  => 'collection',
                         'text'    => '<i class="fa fa-download"></i> Export',
                         'buttons' => [
                             'csv',
                             'excel',
                             'pdf',
                         ],
                    ],
                    'colvis'
                ]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'push_name' => ['name' => 'push_name', 'data' => 'push_name'],
            'device_id' => ['name' => 'device_id', 'data' => 'device_id'],
            'message_id' => ['name' => 'message_id', 'data' => 'message_id'],
            'send_status' => ['name' => 'send_status', 'data' => 'send_status'],
            'read_status' => ['name' => 'read_status', 'data' => 'read_status']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'pushLogDetails';
    }
}

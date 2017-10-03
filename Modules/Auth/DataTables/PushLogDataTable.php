<?php

namespace Modules\Auth\DataTables;

use Modules\Auth\Entities\PushLog;
use Form;
use DB;
use Yajra\Datatables\Services\DataTable;

class PushLogDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'auth::push_logs.datatables_actions')
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
            ->select(
                'push_name',
                DB::raw("DATE(created_at) as \"pushLogDay\""),
                DB::raw('sum(case when send_status = \'sent\' then 1 else 0 end) send_count'),
                DB::raw('sum(case when read_status = \'read\' then 1 else 0 end) read_count')
            )
            ->groupBy(DB::raw("DATE(created_at)"), 'push_name');
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
            'pushLogDay' => ['name' => 'pushLogDay', 'data' => 'pushLogDay'],
            'send_count' => ['name' => 'send_count', 'data' => 'send_count'],
            'read_count' => ['name' => 'read_count', 'data' => 'read_count']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'pushLogs';
    }
}

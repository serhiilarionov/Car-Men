<?php

namespace Modules\Catalog\DataTables;

use Modules\Catalog\Entities\CompanyRating;
use Form;
use Yajra\Datatables\Services\DataTable;

class CompanyRatingDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'catalog::company_ratings.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $companyRatings = CompanyRating::query();

        return $this->applyScopes($companyRatings);
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
            'company_id' => ['name' => 'company_id', 'data' => 'company_id'],
            'user_id' => ['name' => 'user_id', 'data' => 'user_id'],
            'display_name' => ['name' => 'display_name', 'data' => 'display_name'],
            'title' => ['name' => 'title', 'data' => 'title'],
            'text' => ['name' => 'text', 'data' => 'text'],
            'total_rating' => ['name' => 'total_rating', 'data' => 'total_rating'],
            'price_rel' => ['name' => 'price_rel', 'data' => 'price_rel'],
            'answer_name' => ['name' => 'answer_name', 'data' => 'answer_name'],
            'answer_text' => ['name' => 'answer_text', 'data' => 'answer_text'],
            'answer_date' => ['name' => 'answer_date', 'data' => 'answer_date']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'companyRatings';
    }
}

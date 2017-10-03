<?php

namespace Modules\Catalog\DataTables;

use Modules\Catalog\Entities\Company;
use Form;
use Yajra\Datatables\Services\DataTable;

class CompanyDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'catalog::companies.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $companies = Company::query()
          ->leftJoin('catalog_city', 'catalog_company.city_id', '=', 'catalog_city.id')
          ->select([
            'catalog_company.id as id',
            'catalog_company.name as name',
            'catalog_city.name as city_name',
            'catalog_company.address as address',
            'catalog_company.point as point',
            'catalog_company.short_desc as short_desc',
            'catalog_company.picture as picture',
            'catalog_company.rating as rating',
            'catalog_company.price_rel as price_rel',
          ]);

        return $this->applyScopes($companies);
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
            'name' => ['name' => 'name', 'data' => 'name'],
            'city_name' => ['name' => 'catalog_city.name', 'data' => 'city_name'],
            'address' => ['name' => 'address', 'data' => 'address'],
            'lat' => ['name' => 'point', 'data' => 'point.lat'],
            'lng' => ['name' => 'point', 'data' => 'point.lng'],
            'short_desc' => ['name' => 'short_desc', 'data' => 'short_desc'],
            'picture' => ['name' => 'picture', 'data' => 'picture'],
            'rating' => ['name' => 'rating', 'data' => 'rating'],
            'price_rel' => ['name' => 'price_rel', 'data' => 'price_rel'],

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'companies';
    }
}

<?php

namespace Modules\News\DataTables;

use Modules\News\Entities\Article;
use Carbon\Carbon;
use DB;
use Yajra\Datatables\Services\DataTable;

class ParsingDetailDataTable extends DataTable
{

    protected $day;

    /**
     * Set day of parsing
     * @param $day
     * @return $this
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'news::parsings.details.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $parsings = Article::query()
            ->leftJoin('news_sources', 'news_articles.source_id', '=', 'news_sources.id')
            ->where(DB::raw("DATE(created_at)"), '=', $this->day)
            ->select([
                'news_articles.id as id',
                'news_sources.name as source_name',
                'news_articles.title as title',
                'news_articles.text as text',
                'news_articles.source_link as source_link',
                'news_articles.image as image',
                'news_articles.verified as verified',
                'news_articles.publication_date as publication_date'
            ]);

        return $this->applyScopes($parsings);
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
                        'extend' => 'collection',
                        'text' => '<i class="fa fa-download"></i> Export',
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
            'id' => ['name' => 'id', 'data' => 'id'],
            'source_name' => ['name' => 'news_sources.name', 'data' => 'source_name'],
            'title' => ['name' => 'title', 'data' => 'title'],
            'text' => ['name' => 'text', 'data' => 'text'],
            'source_link' => ['name' => 'source_link', 'data' => 'source_link'],
            'image' => ['name' => 'image', 'data' => 'image'],
            'verified' => ['name' => 'verified', 'data' => 'verified'],
            'publication_date' => ['name' => 'publication_date', 'data' => 'publication_date']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'parsing details';
    }
}

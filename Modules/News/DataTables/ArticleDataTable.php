<?php

namespace Modules\News\DataTables;

use Modules\News\Entities\Article;
use Form;
use Yajra\Datatables\Services\DataTable;

class ArticleDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'news::articles.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $articles = Article::query()
            ->leftJoin('news_sources', 'news_articles.source_id', '=', 'news_sources.id')
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

        return $this->applyScopes($articles);
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
        return 'articles';
    }
}

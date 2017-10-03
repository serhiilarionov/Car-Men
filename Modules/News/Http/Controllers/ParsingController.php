<?php

namespace Modules\News\Http\Controllers;

use Modules\News\DataTables\ParsingDataTable;
use Modules\News\Http\Requests;
use Modules\News\Repositories\ArticleRepository;
use App\Http\Controllers\AppBaseController;
use Response;

class ParsingController extends AppBaseController
{
    /** @var  ArticleRepository */
    private $articleRepository;

    public function __construct(ArticleRepository $articlesRepo)
    {
        $this->articleRepository = $articlesRepo;
    }

    /**
     * Display a listing of the parsings.
     *
     * @param ParsingDataTable $parsingDataTable
     * @return Response
     * @internal param ParsingDataTable $parsingDataTable
     */
    public function index(ParsingDataTable $parsingDataTable)
    {
        return $parsingDataTable->render('news::parsings.index');
    }
}

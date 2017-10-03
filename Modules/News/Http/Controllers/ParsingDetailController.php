<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Modules\News\DataTables\ParsingDetailDataTable;
use Modules\News\Http\Requests;
use Modules\News\Http\Requests\CreateArticleRequest;
use Modules\News\Http\Requests\UpdateArticleRequest;
use Illuminate\Http\Request;
use Modules\News\Repositories\ArticleRepository;
use Modules\News\Repositories\SourceRepository;
use Carbon\Carbon;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ParsingDetailController extends AppBaseController
{

    /** @var  ArticleRepository */
    private $articleRepository;

    /** @var  SourceRepository */
    private $sourceRepository;

    public function __construct(ArticleRepository $articlesRepo, SourceRepository $sourceRepo)
    {
        $this->articleRepository = $articlesRepo;
        $this->sourceRepository = $sourceRepo;
    }

    /**
     * Display a listing of the articles by day.
     *
     * @param ParsingDetailDataTable $parsingDetailDataTable
     * @param Request $request
     * @return Response
     * @internal param ParsingDataTable $parsingDataTable
     */
    public function index(ParsingDetailDataTable $parsingDetailDataTable, Request $request)
    {
        $day = $request->get('day');

        if (!$day) {
            Flash::error('Parsing detail not found');
            return redirect(route('news.parsings.index'));
        }
        Session::put('day', $day);
        return $parsingDetailDataTable->setDay($day)->render('news::parsings.details.index');
    }

    /**
     * Show the form for creating a new Articles.
     *
     * @return Response
     */
    public function create()
    {
        $sources = $this->sourceRepository->all();

        return view('news::parsings.details.create')->with(compact('sources'));
    }

    /**
     * Store a newly created Articles in storage.
     *
     * @param CreateArticleRequest $request
     *
     * @return Response
     */
    public function store(CreateArticleRequest $request)
    {
        $input = $request->all();

        $article = $this->articleRepository->create($input);

        Flash::success('Article saved successfully.');
        //set day to session for returning to this day on parsing detail
        $day = Session::get('day');

        return redirect(route('news.parsingDetails.index', ['day' => $day]));
    }

    /**
     * Display the specified Article.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $article = $this->articleRepository->findWithoutFail($id);

        if (empty($article)) {
            Flash::error('Article not found');

            $day = session()->get('day');

            return redirect(route('news.parsingDetails.index', ['day' => $day]));
        }

        $source = $this->sourceRepository->findWhere(['id' => $article->source_id])->first();
        return view('news::parsings.details.show')->with(compact('article', 'source'));
    }

    /**
     * Show the form for editing the specified Article.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $article = $this->articleRepository->findWithoutFail($id);

        if (empty($article)) {
            Flash::error('Article not found');

            $day = session()->get('day');
            return redirect(route('news.parsingDetails.index', ['day' => $day]));
        }
        $sources = $this->sourceRepository->all();
        $source = $this->sourceRepository->findWhere(['id' => $article->source_id])->first();

        return view('news::parsings.details.edit')->with(compact('article', 'source', 'sources'));
    }

    /**
     * Update the specified Article in storage.
     *
     * @param  int $id
     * @param UpdateArticleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateArticleRequest $request)
    {
        $article = $this->articleRepository->findWithoutFail($id);

        if (empty($article)) {
            Flash::error('Article not found');

            $day = session()->get('day');
            return redirect(route('news.parsingDetails.index', ['day' => $day]));
        }

        $article = $this->articleRepository->update($request->all(), $id);

        Flash::success('Article updated successfully.');

        $day = session()->get('day');
        return redirect(route('news.parsingDetails.index', ['day' => $day]));
    }

    /**
     * Remove the specified Article from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $article = $this->articleRepository->findWithoutFail($id);

        $day = session()->get('day');
        if (empty($article)) {
            Flash::error('Article not found');

            return redirect(route('news.parsingDetails.index', ['day' => $day]));
        }

        $this->articleRepository->delete($id);

        Flash::success('Article deleted successfully.');

        return redirect(route('news.parsingDetails.index', ['day' => $day]));
    }

}

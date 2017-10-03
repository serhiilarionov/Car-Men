<?php

namespace Modules\News\Http\Controllers;

use Modules\News\DataTables\ArticleDataTable;
use Modules\News\Http\Requests;
use Modules\News\Http\Requests\CreateArticleRequest;
use Modules\News\Http\Requests\UpdateArticleRequest;
use Modules\News\Repositories\ArticleRepository;
use Modules\News\Repositories\SourceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ArticleController extends AppBaseController
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
     * Display a listing of the Articles.
     *
     * @param ArticleDataTable $articlesDataTable
     * @return Response
     */
    public function index(ArticleDataTable $articleDataTable)
    {
        return $articleDataTable->render('news::articles.index');
    }

    /**
     * Show the form for creating a new Articles.
     *
     * @return Response
     */
    public function create()
    {
        $sources = $this->sourceRepository->all();
        
        return view('news::articles.create')->with(compact('sources'));
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

        $articles = $this->articleRepository->create($input);

        Flash::success('Articles saved successfully.');

        return redirect(route('news.articles.index'));
    }

    /**
     * Display the specified Articles.
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

            return redirect(route('news.articles.index'));
        }

        $source = $this->sourceRepository->findWhere(['id' => $article->source_id])->first();
        return view('news::articles.show')->with(compact('article', 'source'));
    }

    /**
     * Show the form for editing the specified Articles.
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

            return redirect(route('news.articles.index'));
        }
        $sources = $this->sourceRepository->all();
        $source = $this->sourceRepository->findWhere(['id' => $article->source_id])->first();
        return view('news::articles.edit')->with(compact('article', 'source', 'sources'));
    }

    /**
     * Update the specified Articles in storage.
     *
     * @param  int              $id
     * @param UpdateArticleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateArticleRequest $request)
    {
        $article = $this->articleRepository->findWithoutFail($id);

        if (empty($article)) {
            Flash::error('Articles not found');

            return redirect(route('news.articles.index'));
        }

        $article = $this->articleRepository->update($request->all(), $id);

        Flash::success('Articles updated successfully.');

        return redirect(route('news.articles.index'));
    }

    /**
     * Remove the specified Articles from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $articles = $this->articleRepository->findWithoutFail($id);

        if (empty($articles)) {
            Flash::error('Articles not found');

            return redirect(route('news.articles.index'));
        }

        $this->articleRepository->delete($id);

        Flash::success('Articles deleted successfully.');

        return redirect(route('news.articles.index'));
    }
}

<?php

namespace Modules\News\Http\Controllers\API;

use Modules\News\Criterias\LimitOffsetArticlePopularCriteria;
use Modules\News\Criterias\LimitOffsetArticleVerifiedCriteria;
use Modules\News\Events\NewsViewEvent;
use Modules\News\Entities\Article;
use Modules\News\Repositories\ArticleRepository;
use Illuminate\Http\Request;
use Modules\News\Http\Controllers\AppBaseController;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ArticlesController
 * @package Modules\News\Http\Controllers\API
 */

class ArticleAPIController extends AppBaseController
{
    /** @var  ArticleRepository */
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepository = $articleRepo;
        $this->articleRepository->skipPresenter(false);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/news/articles",
     *      summary="Get a listing of the Articles.",
     *      tags={"News"},
     *      description="Get all Articles",
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          name="limit",
     *          description="Limit pagination: 20",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="page",
     *          description="Pagination: 2",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Articles")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->articleRepository->pushCriteria(new RequestCriteria($request));
        $this->articleRepository->pushCriteria(new LimitOffsetArticleVerifiedCriteria($request));
        $limit = $request->get('limit', config('catalog.default_pagination'));

        $articles = $this->articleRepository->paginate($limit);

        return $this->sendResponse($articles, 'Articles retrieved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/news/articles/{id}",
     *      summary="Display the specified Articles",
     *      tags={"News"},
     *      description="Get Articles",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Articles",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Articles"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Articles $articles */
        $articles = $this->articleRepository->active($id);

        if (empty($articles)) {
            return $this->sendResponse($articles, 'Articles not found');
        }

        event(new NewsViewEvent(Article::find($id)));

        return $this->sendResponse($articles, 'Articles retrieved successfully');
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/news/articles/popular",
     *      summary="Display the specified popular Articles",
     *      tags={"News"},
     *      description="Get Articles",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="days",
     *          description="Period in days",
     *          type="integer",
     *          required=true,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="limit",
     *          description="Limit pagination: 20",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="page",
     *          description="Pagination: 2",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Articles"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function popular(Request $request)
    {

        debug('asd');
        $this->articleRepository->pushCriteria(new RequestCriteria($request));
        $this->articleRepository->pushCriteria(new LimitOffsetArticlePopularCriteria($request));

        $limit = $request->get('limit', config('catalog.default_pagination'));

        $articles = $this->articleRepository->paginate($limit);


        return $this->sendResponse($articles, 'Articles retrieved successfully');
    }

}

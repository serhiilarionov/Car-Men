<?php

namespace Modules\Catalog\Http\Controllers\API;

use Illuminate\Support\Facades\Input;
use Modules\Catalog\Criterias\CountCompanyCriteria;
use Modules\Catalog\Http\Requests\API\CreateCategoryAPIRequest;
use Modules\Catalog\Http\Requests\API\UpdateCategoryAPIRequest;
use Modules\Catalog\Entities\Category;
use Modules\Catalog\Repositories\CategoryRepository;
use Modules\Catalog\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use Modules\Catalog\Http\Controllers\AppBaseController;
use App\Criterias\LimitOffsetCriteria;
use Modules\Catalog\Criterias\BoundCriteria;
use Modules\Catalog\Criterias\RadiusCriteria;
use Modules\Catalog\Criterias\DistanceCriteria;
use App\Criterias\RequestCriteria;
use Response;

/**
 * Class CategoryController
 * @package Modules\Catalog\Http\Controllers\API
 */
class CategoryAPIController extends AppBaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;
    /** @var  CompanyRepository */
    private $companyRepository;

    public function __construct(CategoryRepository $categoryRepo, CompanyRepository $companyRepo)
    {
        $this->categoryRepository = $categoryRepo;
        $this->companyRepository = $companyRepo;
        $this->categoryRepository->skipPresenter(false);
        $this->companyRepository->skipPresenter(false);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/categories",
     *      summary="Get a listing of the Categories.",
     *      tags={"Catalog"},
     *      description="Get all Categories",
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          name="Content-Language",
     *          description="Content-Language: 'ru'",
     *          type="string",
     *          required=false,
     *          in="header"
     *      ),
     *     @SWG\Parameter(
     *          name="cityId",
     *          description="City ID",
     *          type="integer",
     *          required=true,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="with",
     *          description="Relations: subcategories",
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
     *                  @SWG\Items(ref="#/definitions/Category")
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
        $this->categoryRepository->pushCriteria(new RequestCriteria($request));
        $this->categoryRepository->pushCriteria(new LimitOffsetCriteria($request));

        $cityId = Input::get('cityId');
        $categories = $this->categoryRepository->getMainCategory($cityId);

        if (empty($categories)) {
            return $this->sendError(trans('apiController.not_found_all', ['entity' => 'Категории']));
        }

        return $this->sendResponse($categories,
          trans('apiController.retrieved_successfully_all', ['entity' => 'Категории']));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/categories/{id}",
     *      summary="Display the specified Category",
     *      tags={"Catalog"},
     *      description="Get Category",
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          name="Content-Language",
     *          description="Content-Language: 'ru'",
     *          type="string",
     *          required=false,
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Category",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="with",
     *          description="Relations: companies",
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
     *                  ref="#/definitions/Category"
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
        /** @var Category $category */
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            return $this->sendError(trans('apiController.not_found', ['entity' => 'Категория']));
        }

        return $this->sendResponse($category, trans('apiController.retrieved_successfully', ['entity' => 'Категория']));
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/categories/{id}/companies",
     *      summary="Display the companies by specific Category",
     *      tags={"Catalog"},
     *      description="Get Companies by Category",
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          name="Content-Language",
     *          description="Content-Language: 'ru'",
     *          type="string",
     *          required=false,
     *          in="header"
     *      ),
     *     @SWG\Parameter(
     *          name="searchFields",
     *          description="name:ilike",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Category",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="search",
     *          description="Search in the repository: 'name:John;email:john@gmail.com'",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="limit",
     *          description="Limit pagination: 20",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="orderBy",
     *          description="Sorting the results: 'id'",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="sortedBy",
     *          description="Sorting direction of the results: 'desc'",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="page",
     *          description="Pagination: 2",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="bound",
     *          description="bound: '33.134698,47.637942,33.598335,55.176781'",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="lat",
     *          description="lat: '33.134698'",
     *          type="string",
     *          required=false,
     *          in="header"
     *      ),
     *     @SWG\Parameter(
     *          name="lng",
     *          description="lng: '47.637942'",
     *          type="string",
     *          required=false,
     *          in="header"
     *      ),
     *     @SWG\Parameter(
     *          name="radius",
     *          description="radius: '10'",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="companies response",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/Company"),
     *          )
     *      )
     * )
     */
    public function companies(Request $request, $id)
    {
        /** @var Category $category */
        $this->companyRepository->pushCriteria(new RequestCriteria($request));
        $this->companyRepository->pushCriteria(new BoundCriteria($request));
        $this->companyRepository->pushCriteria(new RadiusCriteria($request));
        $this->companyRepository->pushCriteria(new DistanceCriteria($request));

        $limit = $request->get('limit', config('catalog.default_pagination'));

        $companies = $this->companyRepository->whereHas('categories', function ($query) use ($id) {
            $query->where('category_id', '=', $id);
        })->paginate($limit);

        if (empty($companies)) {
            return $this->sendResponse([], trans('apiController.not_found_all', ['entity' => 'Компании']));
        }

        return $this->sendResponse($companies,
          trans('apiController.retrieved_successfully_all', ['entity' => 'Компании']));
    }
}

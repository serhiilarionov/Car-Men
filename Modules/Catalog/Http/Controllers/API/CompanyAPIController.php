<?php

namespace Modules\Catalog\Http\Controllers\API;

use Modules\Catalog\Criterias\RadiusCriteria;
use Modules\Catalog\Events\CatalogCompanyShowEvent;
use Modules\Catalog\Http\Requests\API\CreateCompanyAPIRequest;
use Modules\Catalog\Http\Requests\API\UpdateCompanyAPIRequest;
use Modules\Catalog\Entities\Company;
use Modules\Catalog\Repositories\CompanyRepository;
use Modules\Catalog\Criterias\BoundCriteria;
use Modules\Catalog\Criterias\DistanceCriteria;
use Illuminate\Http\Request;
use Modules\Catalog\Http\Controllers\AppBaseController;
use App\Criterias\LimitOffsetCriteria;
use App\Criterias\RequestCriteria;
use Response;

/**
 * Class CompanyController
 * @package Modules\Catalog\Http\Controllers\API
 */
class CompanyAPIController extends AppBaseController
{
    /** @var  CompanyRepository */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepo)
    {
        $this->companyRepository = $companyRepo;
        $this->companyRepository->skipPresenter(false);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/companies",
     *      summary="Get a listing of the Companies.",
     *      tags={"Catalog"},
     *      description="Get all Companies",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Content-Language",
     *          description="Content-Language: 'ru'",
     *          type="string",
     *          required=false,
     *          in="header"
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
     *      @SWG\Parameter(
     *          name="page",
     *          description="Pagination: 2",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="filter",
     *          description="Filtering fields: 'id;name'",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
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
     *          name="with",
     *          description="Add relationship: 'Relations: comforts, categories'",
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
     *                  @SWG\Items(ref="#/definitions/Company")
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
        $this->companyRepository->pushCriteria(new RequestCriteria($request));
        $this->companyRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->companyRepository->pushCriteria(new BoundCriteria($request));
        $this->companyRepository->pushCriteria(new RadiusCriteria($request));
        $this->companyRepository->pushCriteria(new DistanceCriteria($request));

        $limit = $request->get('limit', config('catalog.default_pagination'));
        $companies = $this->companyRepository->paginate($limit);

        return $this->sendResponse($companies,
          trans('apiController.retrieved_successfully_all', ['entity' => 'Компании']));
    }

    /**
     * @param CreateCompanyAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/catalog/companies",
     *      summary="Store a newly created Company in storage",
     *      tags={"Catalog"},
     *      description="Store Company",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Content-Language",
     *          description="Content-Language: 'ru'",
     *          type="string",
     *          required=false,
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Company that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Company")
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
     *                  ref="#/definitions/Company"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCompanyAPIRequest $request)
    {
        $input = $request->all();

        $company = $this->companyRepository->create($input);

        return $this->sendResponse($company,
          trans('apiController.saved_successfully', ['entity' => 'Компания']));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/companies/{id}",
     *      summary="Display the specified Company",
     *      tags={"Catalog"},
     *      description="Get Company",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Content-Language",
     *          description="Content-Language: 'ru'",
     *          type="string",
     *          required=false,
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Company",
     *          type="integer",
     *          required=true,
     *          in="path"
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
     *      @SWG\Parameter(
     *          name="with",
     *          description="Relations: comforts, categories, detail, ratings",
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
     *                  ref="#/definitions/Company"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show(Request $request, $id)
    {

        /** @var Company $company */
        $this->companyRepository->pushCriteria(new DistanceCriteria($request));
        $company = $this->companyRepository->findWithoutFail($id);

        if (empty($company)) {
            return $this->sendError(trans('apiController.not_found', ['entity' => 'Компания']));
        }
        event(new CatalogCompanyShowEvent(Company::find($id)));
        return $this->sendResponse($company,
          trans('apiController.retrieved_successfully', ['entity' => 'Компания']));
    }

    /**
     * @param int $id
     * @param UpdateCompanyAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/catalog/companies/{id}",
     *      summary="Update the specified Company in storage",
     *      tags={"Catalog"},
     *      description="Update Company",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Content-Language",
     *          description="Content-Language: 'ru'",
     *          type="string",
     *          required=false,
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Company",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Company that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Company")
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
     *                  ref="#/definitions/Company"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCompanyAPIRequest $request)
    {
        $input = $request->all();

        if (empty($input)) {
            return $this->sendError(trans('apiController.update_data_not_found'));
        }

        /** @var Company $company */
        $company = $this->companyRepository->findWithoutFail($id);

        if (empty($company)) {
            return $this->sendError(trans('apiController.not_found', ['entity' => 'Компания']));
        }

        $company = $this->companyRepository->update($input, $id);

        return $this->sendResponse($company, trans('apiController.updated_successfully', ['entity' => 'Компания']));
    }

    /**
     * @param Request $request
     * @param int $cityId
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/companies/popularByCity/{cityId}",
     *      summary="Display the most popular companies in city",
     *      tags={"Catalog"},
     *      description="Get popular companies",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Content-Language",
     *          description="Content-Language: 'ru'",
     *          type="string",
     *          required=false,
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="cityId",
     *          description="id of Company",
     *          type="integer",
     *          required=true,
     *          in="path"
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
     *                  ref="#/definitions/Company"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function showPopularCompaniesByCities(Request $request, $cityId)
    {
        /** @var Company $company */
        $this->companyRepository->pushCriteria(new DistanceCriteria($request));
        $companies = $this->companyRepository->getPopularCompanyByCity($cityId);

        if (empty($companies)) {
            return $this->sendResponse([], trans('apiController.not_found_all', ['entity' => 'Компании']));
        }

        return $this->sendResponse($companies,
          trans('apiController.retrieved_successfully_all', ['entity' => 'Компании']));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/catalog/companies/{id}",
     *      summary="Remove the specified Company from storage",
     *      tags={"Catalog"},
     *      description="Delete Company",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Content-Language",
     *          description="Content-Language: 'ru'",
     *          type="string",
     *          required=false,
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Company",
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
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Company $company */
        $company = $this->companyRepository->skipPresenter()->findWithoutFail($id);

        if (empty($company)) {
            return $this->sendError(trans('apiController.not_found', ['entity' => 'Компания']));
        }

        $company->delete();

        return $this->sendResponse($id, trans('apiController.deleted_successfully', ['entity' => 'Компания']));
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/companies/getByBound",
     *      summary="Display the companies by bound",
     *      tags={"Catalog"},
     *      description="Get Companies by bound",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Content-Language",
     *          description="Content-Language: 'ru'",
     *          type="string",
     *          required=false,
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="bound",
     *          description="bound: '33.134698,47.637942,33.598335,55.176781'",
     *          type="string",
     *          required=true,
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
     *                  @SWG\Items(ref="#/definitions/Company")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getByBound(Request $request)
    {
        /** @var Company $company */
        $this->companyRepository->pushCriteria(new BoundCriteria($request));
        $companies = $this->companyRepository->all();

        if (empty($companies)) {
            return $this->sendError(trans('apiController.not_found_all', ['entity' => 'Компании']));
        }

        return $this->sendResponse($companies,
          trans('apiController.retrieved_successfully_all', ['entity' => 'Компании']));
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/companies/getInRadius",
     *      summary="Display companies from radius of point",
     *      tags={"Catalog"},
     *      description="Get companies from radius of point",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Content-Language",
     *          description="Content-Language: 'ru'",
     *          type="string",
     *          required=false,
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="lat",
     *          description="lat: '33.134698'",
     *          type="string",
     *          required=true,
     *          in="header"
     *      ),
     *     @SWG\Parameter(
     *          name="lng",
     *          description="lng: '47.637942'",
     *          type="string",
     *          required=true,
     *          in="header"
     *      ),
     *     @SWG\Parameter(
     *          name="radius",
     *          description="radius: '10'",
     *          type="string",
     *          required=true,
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
     *                  @SWG\Items(ref="#/definitions/Company")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getInRadius(Request $request)
    {
        /** @var Company $company */
        $this->companyRepository->pushCriteria(new DistanceCriteria($request));
        $this->companyRepository->pushCriteria(new RadiusCriteria($request));
        $companies = $this->companyRepository->all();

        if (empty($companies)) {
            return $this->sendError(trans('apiController.not_found_all', ['entity' => 'Компании']));
        }

        return $this->sendResponse($companies,
          trans('apiController.retrieved_successfully_all', ['entity' => 'Компании']));
    }
}

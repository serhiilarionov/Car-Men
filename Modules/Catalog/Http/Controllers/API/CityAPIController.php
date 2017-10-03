<?php

namespace Modules\Catalog\Http\Controllers\API;

use Modules\Catalog\Http\Controllers\AppBaseController;
use Modules\Catalog\Http\Requests\API\CreateCityAPIRequest;
use Modules\Catalog\Http\Requests\API\UpdateCityAPIRequest;
use Modules\Catalog\Entities\City;
use Modules\Catalog\Repositories\CityRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Criterias\RequestCriteria;
use Response;

/**
 * Class CityController
 * @package Modules\Catalog\Http\Controllers\API
 */
class CityAPIController extends AppBaseController
{
    /** @var  CityRepository */
    private $cityRepository;

    public function __construct(CityRepository $cityRepo)
    {
        $this->cityRepository = $cityRepo;
        $this->cityRepository->skipPresenter(false);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/cities",
     *      summary="Get a listing of the Cities.",
     *      tags={"Catalog"},
     *      description="Get all Cities",
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
     *          description="Limit items: '2'",
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
     *      @SWG\Parameter(
     *          name="sortedBy",
     *          description="Sorting direction of the results: 'desc'",
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
     *                  @SWG\Items(ref="#/definitions/City")
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
        $this->cityRepository->pushCriteria(new RequestCriteria($request));
        $this->cityRepository->pushCriteria(new LimitOffsetCriteria($request));
        $cities = $this->cityRepository->hasCompany();

        return $this->sendResponse($cities, trans('apiController.retrieved_successfully_all', ['entity' => 'Города']));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/cities/{id}",
     *      summary="Display the specified City",
     *      tags={"Catalog"},
     *      description="Get City",
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
     *          description="id of City",
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
     *                  ref="#/definitions/City"
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
        /** @var City $city */
        $city = $this->cityRepository->findWithoutFail($id);

        if (empty($city)) {
            return $this->sendError(trans('apiController.not_found_one', ['entity' => 'Город']));
        }

        return $this->sendResponse($city, trans('apiController.retrieved_successfully_one', ['entity' => 'Город']));
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/cities/findByPoint",
     *      summary="Find City by Point",
     *      tags={"Catalog"},
     *      description="Get City by Point",
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
     *          description="Latitude: 47.945307",
     *          type="string",
     *          required=true,
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="lng",
     *          description="Longitude: 33.446723",
     *          type="string",
     *          required=true,
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
     *                  ref="#/definitions/City"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function findByPoint(Request $request)
    {
        $lat = $request->header('lat');
        $lng = $request->header('lng');

        $city = $this->cityRepository->findByPoint($lat, $lng);

        if (empty($city)) {
            return $this->sendError(trans('apiController.not_found_one', ['entity' => 'Город']));
        }

        return $this->sendResponse($city, trans('apiController.retrieved_successfully_one', ['entity' => 'Город']));
    }
}

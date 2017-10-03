<?php

namespace Modules\Catalog\Http\Controllers\API;

use Modules\Catalog\Http\Requests\API\CreateComfortAPIRequest;
use Modules\Catalog\Http\Requests\API\UpdateComfortAPIRequest;
use Modules\Catalog\Entities\Comfort;
use Modules\Catalog\Repositories\ComfortRepository;
use Illuminate\Http\Request;
use Modules\Catalog\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Criterias\RequestCriteria;
use Response;

/**
 * Class ComfortController
 * @package Modules\Catalog\Http\Controllers\API
 */
class ComfortAPIController extends AppBaseController
{
    /** @var  ComfortRepository */
    private $comfortRepository;

    public function __construct(ComfortRepository $comfortRepo)
    {
        $this->comfortRepository = $comfortRepo;
        $this->comfortRepository->skipPresenter(false);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/comforts",
     *      summary="Get a listing of the Comforts.",
     *      tags={"Catalog"},
     *      description="Get all Comforts",
     *      produces={"application/json"},
     *     @SWG\Parameter(
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
     *     @SWG\Parameter(
     *          name="sortedBy",
     *          description="Sorting direction of the results: 'desc'",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="with",
     *          description="Add relationship: 'Relations: companies'",
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
     *                  @SWG\Items(ref="#/definitions/Comfort")
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
        $this->comfortRepository->pushCriteria(new RequestCriteria($request));
        $this->comfortRepository->pushCriteria(new LimitOffsetCriteria($request));
        $comforts = $this->comfortRepository->all();

        return $this->sendResponse($comforts,
          trans('apiController.retrieved_successfully_all', ['entity' => 'Удобства']));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/comforts/{id}",
     *      summary="Display the specified Comfort",
     *      tags={"Catalog"},
     *      description="Get Comfort",
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
     *          description="id of Comfort",
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
     *                  ref="#/definitions/Comfort"
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
        /** @var Comfort $comfort */
        $comfort = $this->comfortRepository->findWithoutFail($id);

        if (empty($comfort)) {
            return $this->sendError(trans('apiController.not_found_it', ['entity' => 'Удобство']));
        }

        return $this->sendResponse($comfort,
          trans('apiController.retrieved_successfully_it', ['entity' => 'Удобство']));
    }
}

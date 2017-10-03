<?php

namespace Modules\Catalog\Http\Controllers\API;

use Modules\Catalog\Http\Requests\API\CreateServiceAPIRequest;
use Modules\Catalog\Http\Requests\API\UpdateServiceAPIRequest;
use Modules\Catalog\Entities\Service;
use Modules\Catalog\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use Modules\Catalog\Http\Controllers\AppBaseController;
use App\Criterias\LimitOffsetCriteria;
use App\Criterias\RequestCriteria;
use Response;

/**
 * Class ServiceController
 * @package Modules\Catalog\Http\Controllers\API
 */
class ServiceAPIController extends AppBaseController
{
    /** @var  ServiceRepository */
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepo)
    {
        $this->serviceRepository = $serviceRepo;
        $this->serviceRepository->skipPresenter(false);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/services",
     *      summary="Get a listing of the Services.",
     *      tags={"Catalog"},
     *      description="Get all Services",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Content-Language",
     *          description="Content-Language: 'ru'",
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
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Service")
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
        $this->serviceRepository->pushCriteria(new RequestCriteria($request));
//        $this->serviceRepository->pushCriteria(new LimitOffsetCriteria($request));
        $services = $this->serviceRepository->all();
        return $this->sendResponse($services,
          trans('apiController.retrieved_successfully_all', ['entity' => 'Сервисы']));
    }

    /**
     * @param CreateServiceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/catalog/services",
     *      summary="Store a newly created Service in storage",
     *      tags={"Catalog"},
     *      description="Store Service",
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
     *          description="Service that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Service")
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
     *                  ref="#/definitions/Service"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateServiceAPIRequest $request)
    {
        $input = $request->all();

        $service = $this->serviceRepository->create($input);

        return $this->sendResponse($service,
          trans('apiController.saved_successfully_one', ['entity' => 'Сервис']));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/services/{id}",
     *      summary="Display the specified Service",
     *      tags={"Catalog"},
     *      description="Get Service",
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
     *          description="id of Service",
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
     *                  ref="#/definitions/Service"
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
        /** @var Service $service */
        $service = $this->serviceRepository->findWithoutFail($id);

        if (empty($service)) {
            return $this->sendError(trans('apiController.not_found_one', ['entity' => 'Сервис']));
        }

        return $this->sendResponse($service, trans('apiController.retrieved_successfully_one', ['entity' => 'Сервис']));
    }

    /**
     * @param int $id
     * @param UpdateServiceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/catalog/services/{id}",
     *      summary="Update the specified Service in storage",
     *      tags={"Catalog"},
     *      description="Update Service",
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
     *          description="id of Service",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Service that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Service")
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
     *                  ref="#/definitions/Service"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateServiceAPIRequest $request)
    {
        $input = $request->all();

        /** @var Service $service */
        $service = $this->serviceRepository->findWithoutFail($id);

        if (empty($service)) {
            return $this->sendError(trans('apiController.not_found_one', ['entity' => 'Сервис']));
        }

        $service = $this->serviceRepository->update($input, $id);

        return $this->sendResponse($service, trans('apiController.updated_successfully_one', ['entity' => 'Сервис']));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/catalog/services/{id}",
     *      summary="Remove the specified Service from storage",
     *      tags={"Catalog"},
     *      description="Delete Service",
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
     *          description="id of Service",
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
        /** @var Service $service */
        $service = $this->serviceRepository->skipPresenter()->findWithoutFail($id);

        if (empty($service)) {
            return $this->sendError(trans('apiController.not_found_one', ['entity' => 'Сервис']));
        }

        $service->delete();

        return $this->sendResponse($id, trans('apiController.deleted_successfully_one', ['entity' => 'Сервис']));
    }
}

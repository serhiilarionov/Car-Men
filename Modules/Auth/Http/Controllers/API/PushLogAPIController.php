<?php

namespace Modules\Auth\Http\Controllers\API;

use Modules\Auth\Http\Requests\API\CreatePushLogAPIRequest;
use Modules\Auth\Http\Requests\API\UpdatePushLogAPIRequest;
use Modules\Auth\Entities\PushLog;
use Modules\Auth\Repositories\PushLogRepository;
use Illuminate\Http\Request;
use Modules\Auth\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PushLogController
 * @package Modules\Auth\Http\Controllers\API
 */

class PushLogAPIController extends AppBaseController
{
    /** @var  PushLogRepository */
    private $pushLogRepository;

    public function __construct(PushLogRepository $pushLogRepo)
    {
        $this->pushLogRepository = $pushLogRepo;
        $this->pushLogRepository->skipPresenter(false);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/auth/pushLogs",
     *      summary="Get a listing of the PushLogs.",
     *      tags={"Auth"},
     *      description="Get all PushLogs",
     *      produces={"application/json"},
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
     *                  @SWG\Items(ref="#/definitions/PushLog")
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
        $this->pushLogRepository->pushCriteria(new RequestCriteria($request));
        $this->pushLogRepository->pushCriteria(new LimitOffsetCriteria($request));
        $pushLogs = $this->pushLogRepository->all();

        return $this->sendResponse($pushLogs, 'Push Logs retrieved successfully');
    }

    /**
     * @param CreatePushLogAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/auth/pushLogs",
     *      summary="Store a newly created PushLog in storage",
     *      tags={"Auth"},
     *      description="Store PushLog",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PushLog that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PushLog")
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
     *                  ref="#/definitions/PushLog"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePushLogAPIRequest $request)
    {
        $input = $request->all();
        $pushLogs = $this->pushLogRepository->create($input);

        return $this->sendResponse($pushLogs, 'Push Log saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/auth/pushLogs/{id}",
     *      summary="Display the specified PushLog",
     *      tags={"Auth"},
     *      description="Get PushLog",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PushLog",
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
     *                  ref="#/definitions/PushLog"
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
        /** @var PushLog $pushLog */
        $pushLog = $this->pushLogRepository->findWithoutFail($id);

        if (empty($pushLog)) {
            return $this->sendError('Push Log not found');
        }

        return $this->sendResponse($pushLog, 'Push Log retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePushLogAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/auth/pushLogs/{id}",
     *      summary="Update the specified PushLog in storage",
     *      tags={"Auth"},
     *      description="Update PushLog",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PushLog",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PushLog that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PushLog")
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
     *                  ref="#/definitions/PushLog"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePushLogAPIRequest $request)
    {
        $input = $request->all();

        /** @var PushLog $pushLog */
        $pushLog = $this->pushLogRepository->findWithoutFail($id);

        if (empty($pushLog)) {
            return $this->sendError('Push Log not found');
        }

        $pushLog = $this->pushLogRepository->update($input, $id);

        return $this->sendResponse($pushLog, 'PushLog updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/auth/pushLogs/{id}",
     *      summary="Remove the specified PushLog from storage",
     *      tags={"Auth"},
     *      description="Delete PushLog",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PushLog",
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
        /** @var PushLog $pushLog */
        $pushLog = $this->pushLogRepository->skipPresenter()->findWithoutFail($id);

        if (empty($pushLog)) {
            return $this->sendError('Push Log not found');
        }

        $pushLog->delete();

        return $this->sendResponse($id, 'Push Log deleted successfully');
    }
    
    /**
     * @param int $id
     * @param UpdatePushLogAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/auth/notifications/{id}/read",
     *      summary="Update the specified PushLog in storage",
     *      tags={"Auth"},
     *      description="Update PushLog",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PushLog",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PushLog that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PushLog")
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
     *                  ref="#/definitions/PushLog"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function setRead($id, UpdatePushLogAPIRequest $request)
    {
        $input = $request->all();
        
        /** @var PushLog $pushLog */
        
        $data['read_status'] = 'read';
        $result = $this->pushLogRepository->updateByMessageId($data, $id);
        
        return $this->sendResponse($result, 'PushLog updated successfully');
    }
    
}

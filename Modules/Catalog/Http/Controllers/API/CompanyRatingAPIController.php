<?php

namespace Modules\Catalog\Http\Controllers\API;

use Modules\Catalog\Http\Requests\API\CreateCompanyRatingAPIRequest;
use Modules\Catalog\Http\Requests\API\UpdateCompanyRatingAPIRequest;
use Modules\Catalog\Entities\CompanyRating;
use Modules\Catalog\Repositories\CompanyRatingCategoryRepository;
use Modules\Catalog\Repositories\CompanyRatingRepository;
use Illuminate\Http\Request;
use Modules\Catalog\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Criterias\RequestCriteria;
use Response;

/**
 * Class CompanyRatingController
 * @package Modules\Catalog\Http\Controllers\API
 */
class CompanyRatingAPIController extends AppBaseController
{
    /** @var  CompanyRatingRepository */
    private $companyRatingRepository;

    /** @var  @var CompanyRatin */
    private $companyRatingCategoryRepository;

    public function __construct(
      CompanyRatingRepository $companyRatingRepo,
      CompanyRatingCategoryRepository $companyRatingCategoryRepo
    ) {
        $this->companyRatingRepository = $companyRatingRepo;
        $this->companyRatingRepository->skipPresenter(false);

        $this->companyRatingCategoryRepository = $companyRatingCategoryRepo;
    }

    /**
     * @param int $id CityId
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/companies/{id}/ratings",
     *      summary="Get a listing of the Company Ratings",
     *      tags={"Catalog"},
     *      description="Get Company Ratings",
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
     *          description="Company Id",
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
     *                  ref="#/definitions/CompanyRating"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function listByCompany(Request $request, $id)
    {
        $this->companyRatingRepository->pushCriteria(new RequestCriteria($request));
        $this->companyRatingRepository->pushCriteria(new LimitOffsetCriteria($request));
        $companyRatings = $this->companyRatingRepository->findByField('company_id', $id);

        if (empty($companyRatings)) {
            return $this->sendError(trans('apiController.not_found_all', ['entity' => 'Рейтинги']));
        }

        return $this->sendResponse($companyRatings,
          trans('apiController.retrieved_successfully_all', ['entity' => 'Рейтинги']));
    }


    /**
     * @param int $id UserId
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/auth/users/{id}/ratings",
     *      summary="Get a listing of the User's Company Ratings",
     *      tags={"Auth"},
     *      description="Get User's Company Ratings",
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
     *          description="User Id",
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
     *                  ref="#/definitions/CompanyRating"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function listByUser(Request $request, $id)
    {
        $this->companyRatingRepository->pushCriteria(new RequestCriteria($request));
        $this->companyRatingRepository->pushCriteria(new LimitOffsetCriteria($request));
        $companyRatings = $this->companyRatingRepository->findByField('user_id', $id);

        if (empty($companyRatings)) {
            return $this->sendError(trans('apiController.not_found_all', ['entity' => 'Рейтинги']));
        }

        return $this->sendResponse($companyRatings,
          trans('apiController.retrieved_successfully_all', ['entity' => 'Рейтинги']));
    }

    /**
     * @param CreateCompanyRatingAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/catalog/companies/ratings",
     *      summary="Store a newly created Company Rating in storage",
     *      tags={"Catalog"},
     *      description="Store Company Rating",
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
     *          description="Company Rating that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CompanyRating")
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
     *                  ref="#/definitions/CompanyRating"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCompanyRatingAPIRequest $request)
    {
        $input = $request->all();

        //set default user data
        $input['user_id'] = \Auth::user()->id;
        $input['display_name'] = isset($input['display_name']) ? $input['display_name'] : \Auth::user()->username;
        $input['display_name'] = $input['display_name'] ?: 'Аноним';

        $companyRatings = $this->companyRatingRepository->skipPresenter(true)->create($input);

        //recalculate company rating
        $this->companyRatingRepository->recalculate($companyRatings->company_id);

        return $this->sendResponse($companyRatings,
          trans('apiController.saved_successfully_one', ['entity' => 'Рейтинг']));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/catalog/companies/ratings/{id}",
     *      summary="Display the specified Company Rating",
     *      tags={"Catalog"},
     *      description="Get Company Rating",
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
     *          description="id of Company Rating",
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
     *                  ref="#/definitions/CompanyRating"
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
        /** @var CompanyRating $companyRating */
        $companyRating = $this->companyRatingRepository->findWithoutFail($id);

        if (empty($companyRating)) {
            return $this->sendError(trans('apiController.not_found_one', ['entity' => 'Рейтинг']));
        }

        return $this->sendResponse($companyRating,
          trans('apiController.retrieved_successfully_one', ['entity' => 'Рейтинг']));
    }

    /**
     * @param int $id
     * @param UpdateCompanyRatingAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/catalog/companies/ratings/{id}",
     *      summary="Update the specified Company Rating in storage",
     *      tags={"Catalog"},
     *      description="Update Company Rating",
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
     *          description="id of Company Rating",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Company Rating that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CompanyRating")
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
     *                  ref="#/definitions/CompanyRating"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCompanyRatingAPIRequest $request)
    {
        $input = $request->all();

        /** @var CompanyRating $companyRating */
        $companyRating = $this->companyRatingRepository->findWithoutFail($id);

        if (empty($companyRating)) {
            return $this->sendError(trans('apiController.not_found_one', ['entity' => 'Рейтинг']));
        }

        $companyRating = $this->companyRatingRepository->update($input, $id);

        //recalculate company rating
        $this->companyRatingRepository->recalculate($companyRating['data']['company_id']);

        return $this->sendResponse($companyRating,
          trans('apiController.updated_successfully_one', ['entity' => 'Рейтинг']));
    }
}

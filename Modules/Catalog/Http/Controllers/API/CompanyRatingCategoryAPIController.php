<?php

namespace Modules\Catalog\Http\Controllers\API;

use Modules\Catalog\Http\Requests\API\CreateCompanyRatingCategoryAPIRequest;
use Modules\Catalog\Http\Requests\API\UpdateCompanyRatingCategoryAPIRequest;
use Modules\Catalog\Entities\CompanyRatingCategory;
use Modules\Catalog\Repositories\CompanyRatingCategoryRepository;
use Illuminate\Http\Request;
use Modules\Catalog\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Criterias\RequestCriteria;
use Response;

/**
 * Class CompanyRatingCategoryController
 * @package Modules\Catalog\Http\Controllers\API
 */

class CompanyRatingCategoryAPIController extends AppBaseController
{
    /** @var  CompanyRatingCategoryRepository */
    private $companyRatingCategoryRepository;

    public function __construct(CompanyRatingCategoryRepository $companyRatingCategoryRepo)
    {
        $this->companyRatingCategoryRepository = $companyRatingCategoryRepo;
        $this->companyRatingCategoryRepository->skipPresenter(false);
    }

    /**
     * @param CreateCompanyRatingCategoryAPIRequest $request
     * @param $id Company Rating Id
     * @return Response
     *
     * @SWG\Post(
     *      path="/catalog/companies/ratings/{id}/categories",
     *      summary="Create or update Category Rating for Company Rating",
     *      tags={"Catalog"},
     *      description="Create or update CompanyRatingCategory",
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
     *          name="category_id",
     *          description="id of Category",
     *          type="integer",
     *          required=true,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="rating",
     *          description="rating from 1 to 5",
     *          type="integer",
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
     *                  ref="#/definitions/CompanyRatingCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCompanyRatingCategoryAPIRequest $request, $id)
    {
        $input = $request->all();

        $attributes = ['category_id' => $input['category_id'], 'company_rating_id' => $id];
        $values = ['rating' => $input['rating']];

        $companyRatingCategories = $this->companyRatingCategoryRepository->updateOrCreate($attributes, $values);

        return $this->sendResponse($companyRatingCategories,
          trans('apiController.saved_successfully_one', ['entity' => 'Рейтинг категории']));
    }

}

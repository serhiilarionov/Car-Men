<?php

namespace Modules\Auth\Http\Controllers\API;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Modules\Auth\Http\Requests\API\LoginAPIRequest;
use Modules\Auth\Http\Requests\API\RegisterUserAPIRequest;
use Modules\Auth\Http\Requests\API\UpdateUserAPIRequest;
use Modules\Auth\Entities\User;
use Modules\Auth\Repositories\UserRepository;
use Modules\Auth\Http\Controllers\AppBaseController;
use Modules\Catalog\Repositories\CompanyRepository;
use Modules\Catalog\Criterias\DistanceCriteria;
use Modules\News\Repositories\ArticleRepository;
use App\Criterias\LimitOffsetCriteria;
use Modules\Auth\Criterias\LimitOffsetArticleFavoritesCriteria;
use Modules\Auth\Criterias\LimitOffsetCompanyFavoritesCriteria;
use Response;

/**
 * Class UserController
 * @package Modules\Auth\Http\Controllers\API
 */
class UserAPIController extends AppBaseController
{
    use AuthenticatesUsers;

    /** @var  UserRepository */
    private $userRepository;

    /** @var  CompanyRepository */
    private $companyRepository;

    /** @var  ArticleRepository */
    private $articleRepository;

    public function __construct(
        UserRepository $userRepo, CompanyRepository $companyRepo, ArticleRepository $articleRepo)
    {
        $this->userRepository = $userRepo;
        $this->userRepository->skipPresenter(false);

        $this->companyRepository = $companyRepo;
        $this->companyRepository->skipPresenter(false);

        $this->articleRepository = $articleRepo;
        $this->articleRepository->skipPresenter(false);
    }

    /**
     * @param LoginAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/auth/users/login",
     *      summary="User login",
     *      tags={"Auth"},
     *      description="User login",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="email",
     *          description="User email",
     *          type="string",
     *          required=true,
     *          in="formData"
     *      ),
     *      @SWG\Parameter(
     *          name="password",
     *          description="User password",
     *          type="string",
     *          required=true,
     *          in="formData"
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
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function login(LoginAPIRequest $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->sendLoginResponse($request, $token);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="/auth/users/logout",
     *      summary="User logout",
     *      tags={"Auth"},
     *      description="User logout",
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
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function logout()
    {
        $this->guard()->logout();

        return $this->sendResponse([], trans('apiController.logout_success'));
    }

    /**
     * @param RegisterUserAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/auth/users/register",
     *      summary="User registration",
     *      tags={"Auth"},
     *      description="User registration",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Content-Language",
     *          description="Content-Language: 'ru'",
     *          type="string",
     *          required=false,
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="name",
     *          description="User name",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *      @SWG\Parameter(
     *          name="email",
     *          description="User email",
     *          type="string",
     *          required=true,
     *          in="formData"
     *      ),
     *      @SWG\Parameter(
     *          name="password",
     *          description="User password",
     *          type="string",
     *          required=true,
     *          in="formData"
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
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function register(RegisterUserAPIRequest $request)
    {
        $user = $this->userRepository->skipPresenter(true)->create($request->all());

        event(new Registered($user));

        $token = $this->guard()->login($user);

        $data = [
            'user' => $user,
            'token' => $token
        ];

        return $this->sendResponse($data, trans('apiController.registration_success'));
    }

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="/auth/users/me",
     *      summary="Display the current User",
     *      tags={"Auth"},
     *      description="Get current User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Content-Language",
     *          description="Content-Language: 'ru'",
     *          type="string",
     *          required=false,
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="with",
     *          description="Add relationship: 'role'",
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
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function me()
    {
        /** @var User $user */
        $user = Auth::user();

        if (empty($user)) {
            return $this->sendError(trans('apiController.user_not_found'));
        }

        return $this->sendResponse($user, trans('apiController.retrieved_successfully_one', ['entity' => 'Пользователь']));
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/auth/users/me/companies/favorites",
     *      summary="Display the current user's favorite companies",
     *      tags={"Auth"},
     *      description="Get favorite companies for current User",
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
     *          required=false,
     *          in="header"
     *      ),
     *      @SWG\Parameter(
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
    public function favoriteCompanies(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (empty($user)) {
            return $this->sendError(trans('apiController.user_not_found'));
        }
        $this->companyRepository->pushCriteria(new DistanceCriteria($request));
        $this->companyRepository->pushCriteria(new LimitOffsetCompanyFavoritesCriteria($request));

        $limit = $request->get('limit', config('auth.defaults.pagination'));
        $favorites = $this->companyRepository->paginate($limit);

        return $this->sendResponse($favorites, trans('apiController.retrieved_successfully_all', ['entity' => 'Избранные компании']));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Post(
     *      path="/auth/users/me/companies/{id}/favorites",
     *      summary="Display added company favorites",
     *      tags={"Auth"},
     *      description="Get favorite companies for current User",
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

    public function addFavoriteCompanies($id)
    {
        /** @var User $user */
        $user = Auth::user();

        if (empty($user)) {
            return $this->sendError(trans('apiController.user_not_found'));
        }

        $favorite = $this->userRepository->addFavoriteCompany($id, $user->id);
        if ($favorite == false) {
            return $this->sendError(trans('apiController.not_added_all', ['entity' => 'Избранные компании']));
        }

        return $this->sendResponse('success', trans('apiController.added_successfully_all', ['entity' => 'Избранные компании']));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/auth/users/me/companies/{id}/favorites",
     *      summary="Delete company favorites",
     *      tags={"Auth"},
     *      description="Delete companies for current User",
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

    public function destroyFavoriteCompanies($id)
    {
        /** @var User $user */
        $user = Auth::user();

        if (empty($user)) {
            return $this->sendError(trans('apiController.user_not_found'));
        }

        $favorite = $this->userRepository->destroyFavoriteCompany($id, $user->id);
        if ($favorite == false) {
            return $this->sendError(trans('apiController.not_deleted_all', ['entity' => 'Избранные компании']));
        }
        return $this->sendResponse('success', trans('apiController.deleted_successfully_all', ['entity' => 'Избранные компании']));
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/auth/users/me/articles/favorites",
     *      summary="Display the current user's favorite articles",
     *      tags={"Auth"},
     *      description="Get favorite articles for current User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Content-Language",
     *          description="Content-Language: 'ru'",
     *          type="string",
     *          required=false,
     *          in="header"
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
     *                  ref="#/definitions/Article"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function favoriteArticles(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (empty($user)) {
            return $this->sendError(trans('apiController.user_not_found'));
        }
        $this->articleRepository->pushCriteria(new LimitOffsetArticleFavoritesCriteria($request));
        
        $limit = $request->get('limit', config('auth.defaults.pagination'));
        $favorites = $this->articleRepository->paginate($limit);

        return $this->sendResponse($favorites, trans('apiController.retrieved_successfully_all', ['entity' => 'Избранные новости']));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Post(
     *      path="/auth/users/me/articles/{id}/favorites",
     *      summary="Added article favorite",
     *      tags={"Auth"},
     *      description="Add favorite article for current User",
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
     *          description="id of Article",
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
     *                  ref="#/definitions/Article"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */

    public function addFavoriteArticle($id)
    {
        /** @var User $user */
        $user = Auth::user();

        if (empty($user)) {
            return $this->sendError(trans('apiController.user_not_found'));
        }

        $favorite = $this->userRepository->addFavoriteArticle($id, $user->id);
        if ($favorite == false) {
            return $this->sendError(trans('apiController.not_added_all', ['entity' => 'Избранные новости']));
        }

        return $this->sendResponse('success', trans('apiController.added_successfully_all', ['entity' => 'Избранные новости']));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/auth/users/me/articles/{id}/favorites",
     *      summary="Delete article favorite",
     *      tags={"Auth"},
     *      description="Delete article for current User",
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
     *          description="id of Article",
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
     *                  ref="#/definitions/Article"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */

    public function destroyFavoriteArticle($id)
    {
        /** @var User $user */
        $user = Auth::user();

        if (empty($user)) {
            return $this->sendError(trans('apiController.user_not_found'));
        }

        $favorite = $this->userRepository->destroyFavoriteArticle($id, $user->id);
        if ($favorite == false) {
            return $this->sendError(trans('apiController.not_deleted', ['entity' => 'Избранная новость']));
        }
        return $this->sendResponse('success', trans('apiController.deleted_successfully', ['entity' => 'Избранная новость']));
    }

    /**
     * @param int $id
     * @param UpdateUserAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/auth/users/update/{id}",
     *      summary="Update the specified User in storage",
     *      tags={"Auth"},
     *      description="Update User",
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
     *          description="id of User",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="User that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/User")
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
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError(trans('apiController.user_not_found'));
        }

        $user = $this->userRepository->update($input, $id);

        return $this->sendResponse($user, trans('apiController.updated_successfully_one', ['entity' => 'Пользователь']));
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param string $token
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request, $token)
    {
        $this->clearLoginAttempts($request);

        $data = [
            'user' => $this->guard()->user(),
            'token' => $token
        ];

        return $this->sendResponse($data, trans('apiController.login_success'));
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return $this->sendError(Lang::get('auth.failed'), 401);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/auth/users/me/companies/lastViewed",
     *      summary="Display the last viewed companies for user",
     *      tags={"Auth"},
     *      description="Get last viewed companies for User",
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
     *          required=false,
     *          in="header"
     *      ),
     *      @SWG\Parameter(
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
     *                  ref="#/definitions/User"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function lastViewedCompanies(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (empty($user)) {
            return $this->sendError(trans('apiController.user_not_found'));
        }

        $this->companyRepository->pushCriteria(new DistanceCriteria($request));
        $viewedCompanies = $this->companyRepository->getLastViewedCompanies($user->id);

        return $this->sendResponse($viewedCompanies, trans('apiController.last_company_viewed'));
    }

}

<?php namespace Modules\Auth\Tests\API;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Auth\Tests\Traits\MakeUserTrait;
use Modules\Catalog\Entities\Company;
use Modules\News\Entities\Article;
use Tests\ApiTestTrait;
use Tests\TestCase;
use Modules\Auth\Repositories\UserRepository;
use Modules\Catalog\Tests\Traits\MakeCompanyTrait;


class UserApiTest extends TestCase
{
    use MakeUserTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions, MakeCompanyTrait;
    
    private $newUser = [
        'name' => 'testuser',
        'email' => 'testuser@email.test',
        'password' => 'testuserpassword'
    ];
    
    private $successLog;
    
    private $token;
    
    public function setUp()
    {
        parent::setUp();
        $this->userRepo = \App::make(UserRepository::class);
    }
    
    public function testUser()
    {
        $this->registerUser();
        $this->registerUserDuplicateEmail();
        $this->registerUserDuplicateName();
        $this->registerUserNoFormatEmail();
        $this->loginUser();
        $this->loginUserErrorEmail();
        $this->loginUserErrorPassword();
        $this->getMeUser();
        $this->logoutUser();
        //$this->printLog();
    }
    
    private function registerUser()
    {
        
        $newUser = $this->newUser;
        
        $jsonData =
            'name=' . $newUser['name']
            . '&email=' . $newUser['email']
            . '&password=' . $newUser['password'];
        
        $this->json('POST', '/api/v1/auth/users/register?' . $jsonData);
        
        $this->responseApiUserEquals('Register user test');
        
    }
    
    private function registerUserDuplicateEmail()
    {
        
        $newUser = $this->newUser;
        
        $userActuality = $this->userRepo->first();
        $userActuality = $userActuality->toArray();
        
        $jsonData =
            'name=' . $newUser['name']
            . '&email=' . $userActuality['email']
            . '&password=' . $newUser['password'];
        
        $this->json('POST', '/api/v1/auth/users/register?' . $jsonData);
        
        $responseCode = json_decode($this->response->getStatusCode(), true);

        $this->assertEquals(400, $responseCode);
        
    }
    
    private function registerUserDuplicateName()
    {
        
        $newUser = $this->newUser;
        
        $userActuality = $this->userRepo->first();
        $userActuality = $userActuality->toArray();
        
        $jsonData =
            'name=' . $userActuality['name']
            . '&email=' . $newUser['email']
            . '&password=' . $newUser['password'];
        
        $this->json('POST', '/api/v1/auth/users/register?' . $jsonData);
        
        $responseCode = json_decode($this->response->getStatusCode(), true);
        
        $this->assertEquals(400, $responseCode);
        
    }
    
    private function registerUserNoFormatEmail()
    {
        
        $newUser = $this->newUser;
        $newUser['email'] = 'testuseremail.test';
        $jsonData =
            'name=' . $newUser['name']
            . '&email=' . $newUser['email']
            . '&password=' . $newUser['password'];
        
        $this->json('POST', '/api/v1/auth/users/register?' . $jsonData);
        
        $responseCode = json_decode($this->response->getStatusCode(), true);
        
        $this->assertEquals(400, $responseCode);
        
    }
    
    private function loginUser()
    {
        
        $newUser = $this->newUser;
        
        $jsonData = '&email=' . $newUser['email']
            . '&password=' . $newUser['password'];
        
        $this->json('POST', '/api/v1/auth/users/login?' . $jsonData);
        
        $response = json_decode($this->response->getContent(), true);
        $this->token = $response['data']['token'];
        
        $this->responseApiUserEquals('Login user test');
        
    }
    
    
    private function getMeUser()
    {
        $headers = 'Authorization: Bearer ' . $this->token;
        
        $this->json('GET', 'api/v1/auth/users/me?' . $headers);
        
        $this->responseApiUserEquals('Get me');
    }
    
    private function loginUserErrorEmail()
    {
        
        $newUser = $this->newUser;
        
        $jsonData = '&email=error' . $newUser['email']
            . '&password=' . $newUser['password'];
        
        $this->json('POST', '/api/v1/auth/users/login?' . $jsonData);
        
        $responseCode = json_decode($this->response->getStatusCode(), true);
        
        $this->assertEquals(401, $responseCode);
        
    }
    
    private function loginUserErrorPassword()
    {
        
        $newUser = $this->newUser;
        
        $jsonData = '&email=error' . $newUser['email']
            . '&password=' . $newUser['password'];
        
        $this->json('POST', '/api/v1/auth/users/login?' . $jsonData);
        
        $responseCode = json_decode($this->response->getStatusCode(), true);
        
        $this->assertEquals(401, $responseCode);
        
    }
    
    /**
     * @return mixed
     *
     * equals new user and response user
     *
     */
    private function responseApiUserEquals($testName)
    {
        
        $newUser = $this->newUser;
        
        $response = json_decode($this->response->getContent(), true);
        
        if (!empty($response['data'])) {
            if (empty($response['data']['user'])) {
                //if response for me user
                $responseUser = $response['data'];
            } else {
                $responseUser = $response['data']['user'];
            }
            
            $newUserEquals = $newUser;
            
            $responseUserEquals = $responseUser;
            
            // unset excess data for equals
            unset(
                $responseUserEquals['id'],
                $responseUserEquals['updated_at'],
                $responseUserEquals['created_at'],
                $newUserEquals['password']
            );
            
            $this->assertEquals($newUserEquals, $responseUserEquals);
        }
        
        $this->successLog[$testName] = $response['success'] ? 'true' : 'false';
        
        return $response;
        
    }
    
    private function logoutUser()
    {
        $this->json('GET', 'api/v1/auth/users/logout?token=' . $this->token);
        $this->responseApiUserEquals('Logout user');
    }
    
    private function printLog()
    {
        print_r($this->successLog);
    }
    
    public function testUserUpdate()
    {
        //PUT /auth/users/update/{id}
        $user = $this->makeUser();
        $editedUser = $this->fakeUserData();
        unset($editedUser['password']);
        $this->json('PUT', '/api/v1/auth/users/update/' . $user->id, $editedUser);
        $this->assertApiResponse($editedUser);
    }
    
    public function testLastViewedCompanies()
    {
        $actualCompany = Company::orderBy('id')->first()->toArray();
        $token = $this->loginActualityUser();
        $this->json('GET', 'api/v1/catalog/companies/' . $actualCompany['id'] . '?token=' . $token);
        $this->json('GET', 'api/v1/auth/users/me/companies/lastViewed?token=' . $token);
        $response = json_decode($this->response->getContent(), true);
        $response['data'][0]['rating'] = floatval($response['data'][0]['rating']);
        unset(
            $response['data'][0]['is_favorite'],
            $response['data'][0]['distance'],
            $actualCompany['created_at'],
            $actualCompany['updated_at'],
            $actualCompany['deleted_at']
        );
        $this->assertEquals($actualCompany, $response['data'][0]);
    }
    
    public function testReadFavorites()
    {
        //GET /auth/users/me/companies/favorites
        // get registered user
        $token = $this->loginActualityUser();
        $favorite = auth()->user()->favorites;
        // get token actuality user
       // $token = $this->loginActualityUser();
        $this->json('GET', '/api/v1/auth/users/me/companies/favorites', ['token' => $token]);
        $this->assertApiCheckLenght($favorite->toArray());
    }
    
    public function testAddFavorites()
    {
        // new company
        $company = $this->fakeCompanyData();
        $company['categories'] = [0];
        // register new company
        $this->json('POST', '/api/v1/catalog/companies', $company);
        // get register new company for getting id
        $responseAddedCompany = json_decode($this->response->getContent(), true);
        // get token actuality user
        $token = $this->loginActualityUser();
        // added new company for actuality registered user
        $this->json('POST', '/api/v1/auth/users/me/companies/'. $responseAddedCompany['data']['id'] .'/favorites', ['token' => $token]);
        // get registered user
        $user = auth()->user();
        $responseCompany = $user->favorites()->where('id', $responseAddedCompany['data']['id'])->get();
        $responseCompany = $responseCompany->toArray()[0];
        unset(
            $responseCompany['id'],
            $responseCompany['created_at'],
            $responseCompany['updated_at'],
            $responseCompany['pivot'],
            $responseCompany['deleted_at'],
            $company['categories']
        );
        $this->assertEquals($company, $responseCompany);
    }

    public function testDeletedFavorites()
    {
        // new company
        $company = $this->fakeCompanyData();
        $company['categories'] = [0];
        // register new company
        $this->json('POST', '/api/v1/catalog/companies', $company);
        // get register new company for getting id
        $responseAddedCompany = json_decode($this->response->getContent(), true);
        // get token actuality user
        $token = $this->loginActualityUser();
        // added new company for actuality registered user
        $this->json('DELETE', '/api/v1/auth/users/me/companies/'. $responseAddedCompany['data']['id'] .'/favorites', ['token' => $token]);
        // get registered user
        $user = auth()->user();
        $responseCompany = $user->favorites()->where('id', $responseAddedCompany['data']['id'])->get();
        $responseCompany = $responseCompany->toArray();
        
        $this->assertEmpty($responseCompany);
    }

    public function testAddArticleFavorites()
    {
        //get article by id
        $article = Article::firstOrFail();
        // get token actuality user
        $token = $this->loginActualityUser();
        // add new article for actuality registered user
        $this->json('POST', '/api/v1/auth/users/me/articles/'. $article['id'] .'/favorites', ['token' => $token]);
        // get registered user
        $user = auth()->user();
        $responseArticle = $user->articles()->where('id', $article['id'])->get();
        $responseArticle = $responseArticle->toArray()[0];

        $article = $article->toArray();
        unset(
            $responseArticle['pivot']
        );
        $this->assertEquals($article, $responseArticle);
    }

    public function testDeleteArticleFavorites()
    {

        //get article by id
        $article = Article::find(1)->firstOrFail();
        // get token actuality user
        $token = $this->loginActualityUser();
        // delete new article for actuality registered user
        $this->json('DELETE', '/api/v1/auth/users/me/articles/'. $article['id'] .'/favorites', ['token' => $token]);
        // get registered user
        $user = auth()->user();
        $responseArticle = $user->articles()->where('id', $article['id'])->get();
        $responseArticle = $responseArticle->toArray();

        $this->assertEmpty($responseArticle);
    }
    
    public function testReadUserCompanyRating()
    {
        //GET /auth/users/{id}/ratings
        // get registered user auth()->user()
        $token = $this->loginActualityUser();
        $user = auth()->user();
        $companyRating = \Modules\Catalog\Entities\CompanyRating::where('user_id', $user->id)->get();
        // get token actuality user
        $this->json('GET', '/api/v1/auth/users/'. $user->id .'/ratings', ['token' => $token]);
        
        $this->assertApiCheckLenght($companyRating->toArray());
    }
}

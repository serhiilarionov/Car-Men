<?php namespace Modules\Auth\Tests\Traits;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Entities\User;
use Modules\Auth\Repositories\UserRepository;

trait MakeUserTrait
{
    /**
     * Create fake instance of User and save it in database
     *
     * @param array $userFields
     * @return User
     */
    public function makeUser($userFields = [])
    {
        /** @var UserRepository $userRepo */
        $userRepo = \App::make(UserRepository::class);
        $theme = $this->fakeUserData($userFields);
        return $userRepo->create($theme);
    }

    /**
     * Get fake instance of User
     *
     * @param array $userFields
     * @return User
     */
    public function fakeUser($userFields = [])
    {
        return new User($this->fakeUserData($userFields));
    }

    /**
     * Get fake data of User
     *
     * @param array $userFields
     * @return array
     */
    public function fakeUserData($userFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->firstName,
            'email' => $fake->email,
            'password' => $fake->password
        ], $userFields);
    }

    public function loginActualityUser()
    {
        $actualityUser = User::orderBy('id')->first();
        $tokenUser = Auth::guard('api')->login($actualityUser);
        return $tokenUser;
    }
}

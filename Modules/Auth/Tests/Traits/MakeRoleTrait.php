<?php namespace Modules\Auth\Tests\Traits;

use Faker\Factory as Faker;
use Modules\Auth\Entities\Role;
use Modules\Auth\Repositories\RoleRepository;

trait MakeRoleTrait
{
    /**
     * Create fake instance of Role and save it in database
     *
     * @param array $roleFields
     * @return Role
     */
    public function makeRole($roleFields = [])
    {
        /** @var RoleRepository $roleRepo */
        $roleRepo = \App::make(RoleRepository::class);
        $theme = $this->fakeRoleData($roleFields);
        return $roleRepo->create($theme);
    }

    /**
     * Get fake instance of Role
     *
     * @param array $roleFields
     * @return Role
     */
    public function fakeRole($roleFields = [])
    {
        return new Role($this->fakeRoleData($roleFields));
    }

    /**
     * Get fake data of Role
     *
     * @param array $roleFields
     * @return array
     */
    public function fakeRoleData($roleFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'display_name' => $fake->word,
            'description' => $fake->text(),
        ], $roleFields);
    }
}

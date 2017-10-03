<?php namespace Modules\Auth\Tests\Traits;

use Faker\Factory as Faker;
use Modules\Auth\Entities\Permission;
use Modules\Auth\Repositories\PermissionRepository;

trait MakePermissionTrait
{
    /**
     * Create fake instance of Permission and save it in database
     *
     * @param array $permissionFields
     * @return Permission
     */
    public function makePermission($permissionFields = [])
    {
        /** @var PermissionRepository $permissionRepo */
        $permissionRepo = \App::make(PermissionRepository::class);
        $theme = $this->fakePermissionData($permissionFields);
        return $permissionRepo->create($theme);
    }

    /**
     * Get fake instance of Permission
     *
     * @param array $permissionFields
     * @return Permission
     */
    public function fakePermission($permissionFields = [])
    {
        return new Permission($this->fakePermissionData($permissionFields));
    }

    /**
     * Get fake data of Permission
     *
     * @param array $permissionFields
     * @return array
     */
    public function fakePermissionData($permissionFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'display_name' => $fake->word,
            'description' => $fake->text(),
        ], $permissionFields);
    }
}

<?php

namespace Modules\Auth\Repositories;

use Modules\Auth\Entities\Permission;
use InfyOm\Generator\Common\BaseRepository;

class PermissionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'display_name',
        'description'
    ];

    protected $skipPresenter = true;

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Permission::class;
    }

    /**
     * Configure presenter
     */
    public function presenter()
    {
        return "Modules\\Auth\\Presenters\\PermissionPresenter";
    }
}

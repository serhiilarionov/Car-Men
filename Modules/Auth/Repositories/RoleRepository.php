<?php

namespace Modules\Auth\Repositories;

use Modules\Auth\Entities\Role;
use InfyOm\Generator\Common\BaseRepository;

class RoleRepository extends BaseRepository
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
        return Role::class;
    }

    /**
     * Configure presenter
     */
    public function presenter()
    {
        return "Modules\\Auth\\Presenters\\RolePresenter";
    }
}

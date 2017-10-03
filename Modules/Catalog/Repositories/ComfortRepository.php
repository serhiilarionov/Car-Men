<?php

namespace Modules\Catalog\Repositories;

use Modules\Catalog\Entities\Comfort;
use InfyOm\Generator\Common\BaseRepository;

class ComfortRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    protected $skipPresenter = true;

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Comfort::class;
    }

    /**
     * Configure presenter
     */
    public function presenter()
    {
        return "Modules\\Catalog\\Presenters\\ComfortPresenter";
    }
}

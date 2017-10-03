<?php

namespace Modules\News\Repositories;

use Modules\News\Entities\Source;
use InfyOm\Generator\Common\BaseRepository;

class SourceRepository extends BaseRepository
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
        return Source::class;
    }

    /**
     * Configure presenter
     */
    public function presenter()
    {
        return "Modules\\News\\Presenters\\SourcePresenter";
    }
    
}

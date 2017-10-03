<?php

namespace Modules\Catalog\Repositories;

use Modules\Catalog\Entities\CompanyDetail;
use InfyOm\Generator\Common\BaseRepository;

class CompanyDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'phones',
        'email',
        'website',
        'work_time',
        'desc',
        'company_id'
    ];

    protected $skipPresenter = true;

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CompanyDetail::class;
    }

    /**
     * Configure presenter
     */
    public function presenter()
    {
        return "Modules\\Catalog\\Presenters\\CompanyDetailPresenter";
    }
}

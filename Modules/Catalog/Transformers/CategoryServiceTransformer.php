<?php

namespace Modules\Catalog\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Catalog\Entities\Category;
use League\Fractal\Resource\Collection;
use Modules\Catalog\Entities\Company;

/**
 * Class CategoryTransformer
 * @package namespace Modules\Catalog\Transformers;
 */
class CategoryServiceTransformer extends TransformerAbstract
{

    private $company;
    private $services;
    public function __construct($services, $company)
    {
        $this->company = $company;
        $this->services = $services;
    }

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'companies',
        'services'
    ];

    /**
     * Transform the Category entity
     * @param Category $model
     *
     * @return array
     */
    public function transform(Category $model)
    {
        return [
            'id' => (int)$model->id,
            'name' => $model->name,
            'active' => $model->active,
            'parent_id' => $model->parent_id,
            'service' => Company::find($this->company->id)->categoryServices($this->services, $model->id)
        ];
    }

}
